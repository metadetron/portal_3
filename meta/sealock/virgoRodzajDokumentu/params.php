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
		case 'virgoRodzajDokumentu':
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
					$values = array('form_only');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_form_only)) {
						$values = array($postValue, 'form_only');
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
					$values = array('form_only');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_form_only)) {
						$values = array($postValue, 'form_only');
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
					$values = array('only_private_records');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_only_private_records)) {
						$values = array($postValue, 'only_private_records');
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
					$values = array('only_private_records');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_only_private_records)) {
						$values = array($postValue, 'only_private_records');
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
					$values = array('force_context_on_first_row');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_force_context_on_first_row)) {
						$values = array($postValue, 'force_context_on_first_row');
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
					$values = array('force_context_on_first_row');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_force_context_on_first_row)) {
						$values = array($postValue, 'force_context_on_first_row');
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
SQL;
			$result = $databaseHandler->queryPrepared($query, false, "ss", array('virgoGrupaDokumentow', 'sealock'));
			foreach ($result as $row) {
				$options[$row['pob_id']] = "{$row['pdf_name']} {$row['pob_custom_title']} [{$row['pge_title']}]";
			}
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
					$values = array('parent_entity_pob_id');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_parent_entity_pob_id)) {
						$values = array($postValue, 'parent_entity_pob_id');
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
					$values = array('parent_entity_pob_id');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_parent_entity_pob_id)) {
						$values = array($postValue, 'parent_entity_pob_id');
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
					$values = array('grandparent_entity_pob_id');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_grandparent_entity_pob_id)) {
						$values = array($postValue, 'grandparent_entity_pob_id');
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
					$values = array('grandparent_entity_pob_id');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_grandparent_entity_pob_id)) {
						$values = array($postValue, 'grandparent_entity_pob_id');
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
					$values = array('when_no_parent_selected');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_when_no_parent_selected)) {
						$values = array($postValue, 'when_no_parent_selected');
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
					$values = array('when_no_parent_selected');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_when_no_parent_selected)) {
						$values = array($postValue, 'when_no_parent_selected');
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
					$values = array('master_mode');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_master_mode)) {
						$values = array($postValue, 'master_mode');
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
					$values = array('master_mode');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_master_mode)) {
						$values = array($postValue, 'master_mode');
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
			$result = $databaseHandler->queryPrepared($query, false, "ss", array('virgoRodzajDokumentu', 'sealock'));
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
					$values = array('master_entity_pob_id');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_master_entity_pob_id)) {
						$values = array($postValue, 'master_entity_pob_id');
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
					$values = array('master_entity_pob_id');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_master_entity_pob_id)) {
						$values = array($postValue, 'master_entity_pob_id');
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
					$values = array('filter_mode');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_filter_mode)) {
						$values = array($postValue, 'filter_mode');
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
					$values = array('filter_mode');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_filter_mode)) {
						$values = array($postValue, 'filter_mode');
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
					$values = array('filter_entity_pob_id');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_filter_entity_pob_id)) {
						$values = array($postValue, 'filter_entity_pob_id');
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
					$values = array('filter_entity_pob_id');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_filter_entity_pob_id)) {
						$values = array($postValue, 'filter_entity_pob_id');
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
					$values = array('css_usage');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_css_usage)) {
						$values = array($postValue, 'css_usage');
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
					$values = array('css_usage');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_css_usage)) {
						$values = array($postValue, 'css_usage');
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
					$values = array('show_details_method');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_details_method)) {
						$values = array($postValue, 'show_details_method');
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
					$values = array('show_details_method');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_details_method)) {
						$values = array($postValue, 'show_details_method');
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
					$values = array('available_page_sizes');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_available_page_sizes)) {
						$values = array($postValue, 'available_page_sizes');
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
					$values = array('available_page_sizes');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_available_page_sizes)) {
						$values = array($postValue, 'available_page_sizes');
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
					$values = array('default_page_size');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_default_page_size)) {
						$values = array($postValue, 'default_page_size');
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
					$values = array('default_page_size');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_default_page_size)) {
						$values = array($postValue, 'default_page_size');
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
			$options["rdk_id"] = "id";
			$options["rdk_nazwa"] = "Nazwa";

			$options["rdk_symbol"] = "Symbol";

			$options["rdk_zwiekszajacy"] = "Zwiększający";

			$options["rdk_wlasny"] = "Własny";

			$options["rdk_wewnetrzny"] = "Wewnętrzny";

			$options["rdk_korekta"] = "Korekta";

			$options["rdk_zastepczy"] = "Zastępczy";

			$options["rdk_ostatni_numer"] = "Ostatni numer";

			$options["rdk_numeracja_rok"] = "Numeracja rok";

			$options["grupa_dokumentow"] = "Grupa dokumentów";
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
					$values = array('default_sort_column');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_default_sort_column)) {
						$values = array($postValue, 'default_sort_column');
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
					$values = array('default_sort_column');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_default_sort_column)) {
						$values = array($postValue, 'default_sort_column');
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
					$values = array('default_sort_mode');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_default_sort_mode)) {
						$values = array($postValue, 'default_sort_mode');
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
					$values = array('default_sort_mode');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_default_sort_mode)) {
						$values = array($postValue, 'default_sort_mode');
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
					$values = array('enable_record_duplication');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_enable_record_duplication)) {
						$values = array($postValue, 'enable_record_duplication');
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
					$values = array('enable_record_duplication');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_enable_record_duplication)) {
						$values = array($postValue, 'enable_record_duplication');
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
					$values = array('show_table_filter');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_table_filter)) {
						$values = array($postValue, 'show_table_filter');
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
					$values = array('show_table_filter');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_table_filter)) {
						$values = array($postValue, 'show_table_filter');
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
					$values = array('empty_values_search');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_empty_values_search)) {
						$values = array($postValue, 'empty_values_search');
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
					$values = array('empty_values_search');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_empty_values_search)) {
						$values = array($postValue, 'empty_values_search');
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
					$values = array('title_value');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_title_value)) {
						$values = array($postValue, 'title_value');
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
					$values = array('under_construction');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_under_construction)) {
						$values = array($postValue, 'under_construction');
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
					$values = array('under_construction');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_under_construction)) {
						$values = array($postValue, 'under_construction');
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
					$values = array('ajax_max_label_list_size');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_ajax_max_label_list_size)) {
						$values = array($postValue, 'ajax_max_label_list_size');
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
					$values = array('extra_ajax_filter');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_extra_ajax_filter)) {
						$values = array($postValue, 'extra_ajax_filter');
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
			<td title="eg. rdk_abc_id in (select abc_id from...)) ">extra_ajax_filter</td>
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
					$values = array('under_construction_allowed_user');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_under_construction_allowed_user)) {
						$values = array($postValue, 'under_construction_allowed_user');
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
					$values = array('under_construction_allowed_user');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_under_construction_allowed_user)) {
						$values = array($postValue, 'under_construction_allowed_user');
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
					$values = array('show_project_name');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_project_name)) {
						$values = array($postValue, 'show_project_name');
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
					$values = array('show_project_name');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_project_name)) {
						$values = array($postValue, 'show_project_name');
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
					$values = array('pdf_font_name');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_pdf_font_name)) {
						$values = array($postValue, 'pdf_font_name');
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
					$values = array('pdf_font_name');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_pdf_font_name)) {
						$values = array($postValue, 'pdf_font_name');
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
					$values = array('pdf_include_bold_font');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_pdf_include_bold_font)) {
						$values = array($postValue, 'pdf_include_bold_font');
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
					$values = array('pdf_include_bold_font');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_pdf_include_bold_font)) {
						$values = array($postValue, 'pdf_include_bold_font');
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
					$values = array('pdf_font_size');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_pdf_font_size)) {
						$values = array($postValue, 'pdf_font_size');
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
					$values = array('pdf_font_size');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_pdf_font_size)) {
						$values = array($postValue, 'pdf_font_size');
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
					$values = array('pdf_max_column_width');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_pdf_max_column_width)) {
						$values = array($postValue, 'pdf_max_column_width');
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
					$values = array('pdf_max_column_width');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_pdf_max_column_width)) {
						$values = array($postValue, 'pdf_max_column_width');
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
					$values = array('pdf_page_orientation');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_pdf_page_orientation)) {
						$values = array($postValue, 'pdf_page_orientation');
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
					$values = array('pdf_page_orientation');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_pdf_page_orientation)) {
						$values = array($postValue, 'pdf_page_orientation');
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
					$values = array('forms_rendering');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_forms_rendering)) {
						$values = array($postValue, 'forms_rendering');
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
					$values = array('forms_rendering');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_forms_rendering)) {
						$values = array($postValue, 'forms_rendering');
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
					$values = array('action_on_row_click');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_action_on_row_click)) {
						$values = array($postValue, 'action_on_row_click');
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
					$values = array('action_on_row_click');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_action_on_row_click)) {
						$values = array($postValue, 'action_on_row_click');
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
					$values = array('action_on_row_click_custom');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_action_on_row_click_custom)) {
						$values = array($postValue, 'action_on_row_click_custom');
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
					$values = array('action_on_row_click_custom');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_action_on_row_click_custom)) {
						$values = array($postValue, 'action_on_row_click_custom');
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
					$values = array('action_on_row_double_click');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_action_on_row_double_click)) {
						$values = array($postValue, 'action_on_row_double_click');
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
					$values = array('action_on_row_double_click');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_action_on_row_double_click)) {
						$values = array($postValue, 'action_on_row_double_click');
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
					$values = array('action_on_row_double_click_custom');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_action_on_row_double_click_custom)) {
						$values = array($postValue, 'action_on_row_double_click_custom');
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
					$values = array('action_on_row_double_click_custom');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_action_on_row_double_click_custom)) {
						$values = array($postValue, 'action_on_row_double_click_custom');
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
					$values = array('hide_audit');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_hide_audit)) {
						$values = array($postValue, 'hide_audit');
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
					$values = array('hide_audit');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_hide_audit)) {
						$values = array($postValue, 'hide_audit');
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
	actionPermissions("Export", $id, $name, $pobId);
	actionPermissions("Form", $id, $name, $pobId);
	actionPermissions("Offline", $id, $name, $pobId);
	actionPermissions("Report", $id, $name, $pobId);
	actionPermissions("SearchForm", $id, $name, $pobId);
	actionPermissions("StoreSelected", $id, $name, $pobId);
	actionPermissions("UpdateTitle", $id, $name, $pobId);
	actionPermissions("Upload", $id, $name, $pobId);
	actionPermissions("View", $id, $name, $pobId);
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
	setPermissions("Export", $id, $pobId);
	setPermissions("Form", $id, $pobId);
	setPermissions("Offline", $id, $pobId);
	setPermissions("Report", $id, $pobId);
	setPermissions("SearchForm", $id, $pobId);
	setPermissions("StoreSelected", $id, $pobId);
	setPermissions("UpdateTitle", $id, $pobId);
	setPermissions("Upload", $id, $pobId);
	setPermissions("View", $id, $pobId);
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
					$values = array('table_form');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_table_form)) {
						$values = array($postValue, 'table_form');
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
					$values = array('table_form');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_table_form)) {
						$values = array($postValue, 'table_form');
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
					$values = array('create_form');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_create_form)) {
						$values = array($postValue, 'create_form');
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
					$values = array('create_form');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_create_form)) {
						$values = array($postValue, 'create_form');
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
					$values = array('edit_form');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_edit_form)) {
						$values = array($postValue, 'edit_form');
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
					$values = array('edit_form');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_edit_form)) {
						$values = array($postValue, 'edit_form');
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
					$values = array('view_form');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_view_form)) {
						$values = array($postValue, 'view_form');
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
					$values = array('view_form');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_view_form)) {
						$values = array($postValue, 'view_form');
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
			$values = array('show_table_nazwa');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_nazwa = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_nazwa = $res;
			$postValue = $_POST['pdf_show_table_nazwa'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_table_nazwa != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_table_nazwa');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_table_nazwa)) {
						$values = array($postValue, 'show_table_nazwa');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_table_nazwa, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_table_nazwa');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_nazwa = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_nazwa = $res;
			}
			$postValue = $_POST['pob_show_table_nazwa'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_table_nazwa != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_table_nazwa');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_table_nazwa)) {
						$values = array($postValue, 'show_table_nazwa');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_table_nazwa, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_table_nazwa');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_nazwa = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_nazwa = $res;
			}
?>
		<tr>
			<td title="">
					show_table_nazwa
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_table_nazwa" >
						<option value="" <?php echo !isset($pdf_show_table_nazwa) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_table_nazwa) && strrpos(",".$pdf_show_table_nazwa.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_table_nazwa" value="<?php echo $pdf_show_table_nazwa ?>">
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
					<select name="pob_show_table_nazwa" >
						<option value="" <?php echo !isset($pob_show_table_nazwa) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_table_nazwa) && strrpos(",".$pob_show_table_nazwa.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_table_nazwa" value="<?php echo $pob_show_table_nazwa ?>">
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
			$values = array('show_table_symbol');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_symbol = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_symbol = $res;
			$postValue = $_POST['pdf_show_table_symbol'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_table_symbol != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_table_symbol');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_table_symbol)) {
						$values = array($postValue, 'show_table_symbol');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_table_symbol, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_table_symbol');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_symbol = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_symbol = $res;
			}
			$postValue = $_POST['pob_show_table_symbol'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_table_symbol != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_table_symbol');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_table_symbol)) {
						$values = array($postValue, 'show_table_symbol');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_table_symbol, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_table_symbol');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_symbol = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_symbol = $res;
			}
?>
		<tr>
			<td title="">
				<strong>
					show_table_symbol
				</strong>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_table_symbol" >
						<option value="" <?php echo !isset($pdf_show_table_symbol) ? "selected " : "" ?>>!!!OBLIGATORY!!!</option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_table_symbol) && strrpos(",".$pdf_show_table_symbol.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_table_symbol" value="<?php echo $pdf_show_table_symbol ?>">
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
					<select name="pob_show_table_symbol" >
						<option value="" <?php echo !isset($pob_show_table_symbol) ? "selected " : "" ?>>!!!OBLIGATORY!!!</option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_table_symbol) && strrpos(",".$pob_show_table_symbol.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_table_symbol" value="<?php echo $pob_show_table_symbol ?>">
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
			$values = array('show_table_zwiekszajacy');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_zwiekszajacy = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_zwiekszajacy = $res;
			$postValue = $_POST['pdf_show_table_zwiekszajacy'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_table_zwiekszajacy != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_table_zwiekszajacy');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_table_zwiekszajacy)) {
						$values = array($postValue, 'show_table_zwiekszajacy');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_table_zwiekszajacy, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_table_zwiekszajacy');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_zwiekszajacy = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_zwiekszajacy = $res;
			}
			$postValue = $_POST['pob_show_table_zwiekszajacy'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_table_zwiekszajacy != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_table_zwiekszajacy');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_table_zwiekszajacy)) {
						$values = array($postValue, 'show_table_zwiekszajacy');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_table_zwiekszajacy, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_table_zwiekszajacy');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_zwiekszajacy = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_zwiekszajacy = $res;
			}
?>
		<tr>
			<td title="">
					show_table_zwiekszajacy
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_table_zwiekszajacy" >
						<option value="" <?php echo !isset($pdf_show_table_zwiekszajacy) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_table_zwiekszajacy) && strrpos(",".$pdf_show_table_zwiekszajacy.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_table_zwiekszajacy" value="<?php echo $pdf_show_table_zwiekszajacy ?>">
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
					<select name="pob_show_table_zwiekszajacy" >
						<option value="" <?php echo !isset($pob_show_table_zwiekszajacy) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_table_zwiekszajacy) && strrpos(",".$pob_show_table_zwiekszajacy.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_table_zwiekszajacy" value="<?php echo $pob_show_table_zwiekszajacy ?>">
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
			$values = array('show_table_wlasny');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_wlasny = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_wlasny = $res;
			$postValue = $_POST['pdf_show_table_wlasny'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_table_wlasny != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_table_wlasny');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_table_wlasny)) {
						$values = array($postValue, 'show_table_wlasny');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_table_wlasny, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_table_wlasny');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_wlasny = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_wlasny = $res;
			}
			$postValue = $_POST['pob_show_table_wlasny'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_table_wlasny != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_table_wlasny');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_table_wlasny)) {
						$values = array($postValue, 'show_table_wlasny');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_table_wlasny, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_table_wlasny');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_wlasny = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_wlasny = $res;
			}
?>
		<tr>
			<td title="">
					show_table_wlasny
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_table_wlasny" >
						<option value="" <?php echo !isset($pdf_show_table_wlasny) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_table_wlasny) && strrpos(",".$pdf_show_table_wlasny.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_table_wlasny" value="<?php echo $pdf_show_table_wlasny ?>">
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
					<select name="pob_show_table_wlasny" >
						<option value="" <?php echo !isset($pob_show_table_wlasny) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_table_wlasny) && strrpos(",".$pob_show_table_wlasny.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_table_wlasny" value="<?php echo $pob_show_table_wlasny ?>">
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
			$values = array('show_table_wewnetrzny');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_wewnetrzny = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_wewnetrzny = $res;
			$postValue = $_POST['pdf_show_table_wewnetrzny'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_table_wewnetrzny != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_table_wewnetrzny');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_table_wewnetrzny)) {
						$values = array($postValue, 'show_table_wewnetrzny');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_table_wewnetrzny, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_table_wewnetrzny');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_wewnetrzny = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_wewnetrzny = $res;
			}
			$postValue = $_POST['pob_show_table_wewnetrzny'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_table_wewnetrzny != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_table_wewnetrzny');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_table_wewnetrzny)) {
						$values = array($postValue, 'show_table_wewnetrzny');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_table_wewnetrzny, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_table_wewnetrzny');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_wewnetrzny = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_wewnetrzny = $res;
			}
?>
		<tr>
			<td title="">
					show_table_wewnetrzny
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_table_wewnetrzny" >
						<option value="" <?php echo !isset($pdf_show_table_wewnetrzny) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_table_wewnetrzny) && strrpos(",".$pdf_show_table_wewnetrzny.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_table_wewnetrzny" value="<?php echo $pdf_show_table_wewnetrzny ?>">
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
					<select name="pob_show_table_wewnetrzny" >
						<option value="" <?php echo !isset($pob_show_table_wewnetrzny) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_table_wewnetrzny) && strrpos(",".$pob_show_table_wewnetrzny.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_table_wewnetrzny" value="<?php echo $pob_show_table_wewnetrzny ?>">
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
			$values = array('show_table_korekta');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_korekta = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_korekta = $res;
			$postValue = $_POST['pdf_show_table_korekta'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_table_korekta != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_table_korekta');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_table_korekta)) {
						$values = array($postValue, 'show_table_korekta');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_table_korekta, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_table_korekta');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_korekta = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_korekta = $res;
			}
			$postValue = $_POST['pob_show_table_korekta'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_table_korekta != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_table_korekta');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_table_korekta)) {
						$values = array($postValue, 'show_table_korekta');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_table_korekta, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_table_korekta');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_korekta = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_korekta = $res;
			}
?>
		<tr>
			<td title="">
					show_table_korekta
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_table_korekta" >
						<option value="" <?php echo !isset($pdf_show_table_korekta) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_table_korekta) && strrpos(",".$pdf_show_table_korekta.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_table_korekta" value="<?php echo $pdf_show_table_korekta ?>">
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
					<select name="pob_show_table_korekta" >
						<option value="" <?php echo !isset($pob_show_table_korekta) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_table_korekta) && strrpos(",".$pob_show_table_korekta.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_table_korekta" value="<?php echo $pob_show_table_korekta ?>">
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
			$values = array('show_table_zastepczy');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_zastepczy = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_zastepczy = $res;
			$postValue = $_POST['pdf_show_table_zastepczy'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_table_zastepczy != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_table_zastepczy');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_table_zastepczy)) {
						$values = array($postValue, 'show_table_zastepczy');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_table_zastepczy, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_table_zastepczy');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_zastepczy = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_zastepczy = $res;
			}
			$postValue = $_POST['pob_show_table_zastepczy'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_table_zastepczy != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_table_zastepczy');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_table_zastepczy)) {
						$values = array($postValue, 'show_table_zastepczy');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_table_zastepczy, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_table_zastepczy');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_zastepczy = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_zastepczy = $res;
			}
?>
		<tr>
			<td title="">
					show_table_zastepczy
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_table_zastepczy" >
						<option value="" <?php echo !isset($pdf_show_table_zastepczy) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_table_zastepczy) && strrpos(",".$pdf_show_table_zastepczy.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_table_zastepczy" value="<?php echo $pdf_show_table_zastepczy ?>">
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
					<select name="pob_show_table_zastepczy" >
						<option value="" <?php echo !isset($pob_show_table_zastepczy) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_table_zastepczy) && strrpos(",".$pob_show_table_zastepczy.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_table_zastepczy" value="<?php echo $pob_show_table_zastepczy ?>">
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
			$values = array('show_table_ostatni_numer');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_ostatni_numer = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_ostatni_numer = $res;
			$postValue = $_POST['pdf_show_table_ostatni_numer'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_table_ostatni_numer != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_table_ostatni_numer');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_table_ostatni_numer)) {
						$values = array($postValue, 'show_table_ostatni_numer');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_table_ostatni_numer, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_table_ostatni_numer');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_ostatni_numer = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_ostatni_numer = $res;
			}
			$postValue = $_POST['pob_show_table_ostatni_numer'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_table_ostatni_numer != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_table_ostatni_numer');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_table_ostatni_numer)) {
						$values = array($postValue, 'show_table_ostatni_numer');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_table_ostatni_numer, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_table_ostatni_numer');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_ostatni_numer = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_ostatni_numer = $res;
			}
?>
		<tr>
			<td title="">
					show_table_ostatni_numer
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_table_ostatni_numer" >
						<option value="" <?php echo !isset($pdf_show_table_ostatni_numer) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_table_ostatni_numer) && strrpos(",".$pdf_show_table_ostatni_numer.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_table_ostatni_numer" value="<?php echo $pdf_show_table_ostatni_numer ?>">
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
					<select name="pob_show_table_ostatni_numer" >
						<option value="" <?php echo !isset($pob_show_table_ostatni_numer) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_table_ostatni_numer) && strrpos(",".$pob_show_table_ostatni_numer.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_table_ostatni_numer" value="<?php echo $pob_show_table_ostatni_numer ?>">
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
			$values = array('show_table_numeracja_rok');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_numeracja_rok = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_numeracja_rok = $res;
			$postValue = $_POST['pdf_show_table_numeracja_rok'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_table_numeracja_rok != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_table_numeracja_rok');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_table_numeracja_rok)) {
						$values = array($postValue, 'show_table_numeracja_rok');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_table_numeracja_rok, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_table_numeracja_rok');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_numeracja_rok = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_numeracja_rok = $res;
			}
			$postValue = $_POST['pob_show_table_numeracja_rok'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_table_numeracja_rok != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_table_numeracja_rok');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_table_numeracja_rok)) {
						$values = array($postValue, 'show_table_numeracja_rok');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_table_numeracja_rok, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_table_numeracja_rok');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_numeracja_rok = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_numeracja_rok = $res;
			}
?>
		<tr>
			<td title="">
					show_table_numeracja_rok
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_table_numeracja_rok" >
						<option value="" <?php echo !isset($pdf_show_table_numeracja_rok) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_table_numeracja_rok) && strrpos(",".$pdf_show_table_numeracja_rok.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_table_numeracja_rok" value="<?php echo $pdf_show_table_numeracja_rok ?>">
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
					<select name="pob_show_table_numeracja_rok" >
						<option value="" <?php echo !isset($pob_show_table_numeracja_rok) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_table_numeracja_rok) && strrpos(",".$pob_show_table_numeracja_rok.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_table_numeracja_rok" value="<?php echo $pob_show_table_numeracja_rok ?>">
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
<?php
			$options = array();
			$options["0"] = "No";
			$options["1"] = "Yes";
			$options["2"] = "Change";
?>
<?php
			$types = "s";
			$values = array('show_table_grupa_dokumentow');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_grupa_dokumentow = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_grupa_dokumentow = $res;
			$postValue = $_POST['pdf_show_table_grupa_dokumentow'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_table_grupa_dokumentow != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_table_grupa_dokumentow');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_table_grupa_dokumentow)) {
						$values = array($postValue, 'show_table_grupa_dokumentow');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_table_grupa_dokumentow, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_table_grupa_dokumentow');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_grupa_dokumentow = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_grupa_dokumentow = $res;
			}
			$postValue = $_POST['pob_show_table_grupa_dokumentow'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_table_grupa_dokumentow != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_table_grupa_dokumentow');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_table_grupa_dokumentow)) {
						$values = array($postValue, 'show_table_grupa_dokumentow');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_table_grupa_dokumentow, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_table_grupa_dokumentow');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_grupa_dokumentow = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_grupa_dokumentow = $res;
			}
?>
		<tr>
			<td title="">
					show_table_grupa_dokumentow
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_table_grupa_dokumentow" >
						<option value="" <?php echo !isset($pdf_show_table_grupa_dokumentow) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_table_grupa_dokumentow) && strrpos(",".$pdf_show_table_grupa_dokumentow.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_table_grupa_dokumentow" value="<?php echo $pdf_show_table_grupa_dokumentow ?>">
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
					<select name="pob_show_table_grupa_dokumentow" >
						<option value="" <?php echo !isset($pob_show_table_grupa_dokumentow) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_table_grupa_dokumentow) && strrpos(",".$pob_show_table_grupa_dokumentow.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_table_grupa_dokumentow" value="<?php echo $pob_show_table_grupa_dokumentow ?>">
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
<?php
			$options = array();
			$options["0"] = "No";
			$options["1"] = "Yes";
?>
<?php
			$types = "s";
			$values = array('show_table_dokumenty_ksiegowe');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_dokumenty_ksiegowe = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_dokumenty_ksiegowe = $res;
			$postValue = $_POST['pdf_show_table_dokumenty_ksiegowe'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_table_dokumenty_ksiegowe != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_table_dokumenty_ksiegowe');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_table_dokumenty_ksiegowe)) {
						$values = array($postValue, 'show_table_dokumenty_ksiegowe');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_table_dokumenty_ksiegowe, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_table_dokumenty_ksiegowe');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_dokumenty_ksiegowe = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_dokumenty_ksiegowe = $res;
			}
			$postValue = $_POST['pob_show_table_dokumenty_ksiegowe'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_table_dokumenty_ksiegowe != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_table_dokumenty_ksiegowe');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_table_dokumenty_ksiegowe)) {
						$values = array($postValue, 'show_table_dokumenty_ksiegowe');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_table_dokumenty_ksiegowe, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_table_dokumenty_ksiegowe');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_dokumenty_ksiegowe = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_dokumenty_ksiegowe = $res;
			}
?>
		<tr>
			<td title="">
					show_table_dokumenty_ksiegowe
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_table_dokumenty_ksiegowe" >
						<option value="" <?php echo !isset($pdf_show_table_dokumenty_ksiegowe) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_table_dokumenty_ksiegowe) && strrpos(",".$pdf_show_table_dokumenty_ksiegowe.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_table_dokumenty_ksiegowe" value="<?php echo $pdf_show_table_dokumenty_ksiegowe ?>">
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
					<select name="pob_show_table_dokumenty_ksiegowe" >
						<option value="" <?php echo !isset($pob_show_table_dokumenty_ksiegowe) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_table_dokumenty_ksiegowe) && strrpos(",".$pob_show_table_dokumenty_ksiegowe.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_table_dokumenty_ksiegowe" value="<?php echo $pob_show_table_dokumenty_ksiegowe ?>">
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
			$values = array('show_create_nazwa');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_nazwa = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_nazwa = $res;
			$values = array("show_create_nazwa_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_nazwa_obligatory = $res;
			$postValue = $_POST['pdf_show_create_nazwa'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_create_nazwa != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_create_nazwa');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_create_nazwa)) {
						$values = array($postValue, 'show_create_nazwa');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_nazwa, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_nazwa');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_nazwa = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_nazwa = $res;
			$values = array("show_create_nazwa_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_nazwa_obligatory = $res;
			}
			$postValue = $_POST['pob_show_create_nazwa'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_create_nazwa != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_create_nazwa');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_create_nazwa)) {
						$values = array($postValue, 'show_create_nazwa');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_nazwa, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_nazwa');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_nazwa = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_nazwa = $res;
			$values = array("show_create_nazwa_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_nazwa_obligatory = $res;
			}
			$postValue = $_POST['pob_show_create_nazwa_obligatory'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_create_nazwa_obligatory != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_create_nazwa_obligatory');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_create_nazwa_obligatory)) {
						$values = array($postValue, 'show_create_nazwa_obligatory');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_nazwa_obligatory, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_nazwa_obligatory');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_nazwa_obligatory = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_nazwa_obligatory = $res;
			$values = array("show_create_nazwa_obligatory_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_nazwa_obligatory_obligatory = $res;
			}
?>
		<tr>
			<td title="">
					show_create_nazwa
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_create_nazwa" >
						<option value="" <?php echo !isset($pdf_show_create_nazwa) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_create_nazwa) && strrpos(",".$pdf_show_create_nazwa.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_create_nazwa" value="<?php echo $pdf_show_create_nazwa ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
					Obl:<input type="checkbox" name="pob_show_create_nazwa_obligatory" value="1" <?php echo $pob_show_create_nazwa_obligatory == "1" ? " checked='checked' " : "" ?>/>
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_create_nazwa" >
						<option value="" <?php echo !isset($pob_show_create_nazwa) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_create_nazwa) && strrpos(",".$pob_show_create_nazwa.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_create_nazwa" value="<?php echo $pob_show_create_nazwa ?>">
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
			$values = array('show_create_symbol');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_symbol = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_symbol = $res;
			$postValue = $_POST['pdf_show_create_symbol'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_create_symbol != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_create_symbol');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_create_symbol)) {
						$values = array($postValue, 'show_create_symbol');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_symbol, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_symbol');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_symbol = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_symbol = $res;
			}
			$postValue = $_POST['pob_show_create_symbol'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_create_symbol != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_create_symbol');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_create_symbol)) {
						$values = array($postValue, 'show_create_symbol');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_symbol, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_symbol');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_symbol = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_symbol = $res;
			}
?>
		<tr>
			<td title="">
				<strong>
					show_create_symbol
				</strong>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_create_symbol" >
						<option value="" <?php echo !isset($pdf_show_create_symbol) ? "selected " : "" ?>>!!!OBLIGATORY!!!</option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_create_symbol) && strrpos(",".$pdf_show_create_symbol.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_create_symbol" value="<?php echo $pdf_show_create_symbol ?>">
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
					<select name="pob_show_create_symbol" >
						<option value="" <?php echo !isset($pob_show_create_symbol) ? "selected " : "" ?>>!!!OBLIGATORY!!!</option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_create_symbol) && strrpos(",".$pob_show_create_symbol.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_create_symbol" value="<?php echo $pob_show_create_symbol ?>">
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
			$values = array('show_create_zwiekszajacy');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_zwiekszajacy = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_zwiekszajacy = $res;
			$values = array("show_create_zwiekszajacy_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_zwiekszajacy_obligatory = $res;
			$postValue = $_POST['pdf_show_create_zwiekszajacy'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_create_zwiekszajacy != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_create_zwiekszajacy');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_create_zwiekszajacy)) {
						$values = array($postValue, 'show_create_zwiekszajacy');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_zwiekszajacy, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_zwiekszajacy');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_zwiekszajacy = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_zwiekszajacy = $res;
			$values = array("show_create_zwiekszajacy_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_zwiekszajacy_obligatory = $res;
			}
			$postValue = $_POST['pob_show_create_zwiekszajacy'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_create_zwiekszajacy != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_create_zwiekszajacy');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_create_zwiekszajacy)) {
						$values = array($postValue, 'show_create_zwiekszajacy');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_zwiekszajacy, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_zwiekszajacy');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_zwiekszajacy = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_zwiekszajacy = $res;
			$values = array("show_create_zwiekszajacy_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_zwiekszajacy_obligatory = $res;
			}
			$postValue = $_POST['pob_show_create_zwiekszajacy_obligatory'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_create_zwiekszajacy_obligatory != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_create_zwiekszajacy_obligatory');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_create_zwiekszajacy_obligatory)) {
						$values = array($postValue, 'show_create_zwiekszajacy_obligatory');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_zwiekszajacy_obligatory, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_zwiekszajacy_obligatory');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_zwiekszajacy_obligatory = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_zwiekszajacy_obligatory = $res;
			$values = array("show_create_zwiekszajacy_obligatory_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_zwiekszajacy_obligatory_obligatory = $res;
			}
?>
		<tr>
			<td title="">
					show_create_zwiekszajacy
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_create_zwiekszajacy" >
						<option value="" <?php echo !isset($pdf_show_create_zwiekszajacy) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_create_zwiekszajacy) && strrpos(",".$pdf_show_create_zwiekszajacy.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_create_zwiekszajacy" value="<?php echo $pdf_show_create_zwiekszajacy ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
					Obl:<input type="checkbox" name="pob_show_create_zwiekszajacy_obligatory" value="1" <?php echo $pob_show_create_zwiekszajacy_obligatory == "1" ? " checked='checked' " : "" ?>/>
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_create_zwiekszajacy" >
						<option value="" <?php echo !isset($pob_show_create_zwiekszajacy) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_create_zwiekszajacy) && strrpos(",".$pob_show_create_zwiekszajacy.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_create_zwiekszajacy" value="<?php echo $pob_show_create_zwiekszajacy ?>">
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
			$values = array('show_create_wlasny');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_wlasny = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_wlasny = $res;
			$values = array("show_create_wlasny_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_wlasny_obligatory = $res;
			$postValue = $_POST['pdf_show_create_wlasny'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_create_wlasny != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_create_wlasny');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_create_wlasny)) {
						$values = array($postValue, 'show_create_wlasny');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_wlasny, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_wlasny');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_wlasny = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_wlasny = $res;
			$values = array("show_create_wlasny_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_wlasny_obligatory = $res;
			}
			$postValue = $_POST['pob_show_create_wlasny'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_create_wlasny != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_create_wlasny');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_create_wlasny)) {
						$values = array($postValue, 'show_create_wlasny');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_wlasny, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_wlasny');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_wlasny = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_wlasny = $res;
			$values = array("show_create_wlasny_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_wlasny_obligatory = $res;
			}
			$postValue = $_POST['pob_show_create_wlasny_obligatory'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_create_wlasny_obligatory != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_create_wlasny_obligatory');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_create_wlasny_obligatory)) {
						$values = array($postValue, 'show_create_wlasny_obligatory');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_wlasny_obligatory, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_wlasny_obligatory');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_wlasny_obligatory = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_wlasny_obligatory = $res;
			$values = array("show_create_wlasny_obligatory_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_wlasny_obligatory_obligatory = $res;
			}
?>
		<tr>
			<td title="">
					show_create_wlasny
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_create_wlasny" >
						<option value="" <?php echo !isset($pdf_show_create_wlasny) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_create_wlasny) && strrpos(",".$pdf_show_create_wlasny.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_create_wlasny" value="<?php echo $pdf_show_create_wlasny ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
					Obl:<input type="checkbox" name="pob_show_create_wlasny_obligatory" value="1" <?php echo $pob_show_create_wlasny_obligatory == "1" ? " checked='checked' " : "" ?>/>
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_create_wlasny" >
						<option value="" <?php echo !isset($pob_show_create_wlasny) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_create_wlasny) && strrpos(",".$pob_show_create_wlasny.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_create_wlasny" value="<?php echo $pob_show_create_wlasny ?>">
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
			$values = array('show_create_wewnetrzny');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_wewnetrzny = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_wewnetrzny = $res;
			$values = array("show_create_wewnetrzny_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_wewnetrzny_obligatory = $res;
			$postValue = $_POST['pdf_show_create_wewnetrzny'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_create_wewnetrzny != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_create_wewnetrzny');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_create_wewnetrzny)) {
						$values = array($postValue, 'show_create_wewnetrzny');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_wewnetrzny, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_wewnetrzny');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_wewnetrzny = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_wewnetrzny = $res;
			$values = array("show_create_wewnetrzny_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_wewnetrzny_obligatory = $res;
			}
			$postValue = $_POST['pob_show_create_wewnetrzny'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_create_wewnetrzny != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_create_wewnetrzny');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_create_wewnetrzny)) {
						$values = array($postValue, 'show_create_wewnetrzny');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_wewnetrzny, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_wewnetrzny');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_wewnetrzny = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_wewnetrzny = $res;
			$values = array("show_create_wewnetrzny_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_wewnetrzny_obligatory = $res;
			}
			$postValue = $_POST['pob_show_create_wewnetrzny_obligatory'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_create_wewnetrzny_obligatory != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_create_wewnetrzny_obligatory');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_create_wewnetrzny_obligatory)) {
						$values = array($postValue, 'show_create_wewnetrzny_obligatory');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_wewnetrzny_obligatory, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_wewnetrzny_obligatory');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_wewnetrzny_obligatory = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_wewnetrzny_obligatory = $res;
			$values = array("show_create_wewnetrzny_obligatory_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_wewnetrzny_obligatory_obligatory = $res;
			}
?>
		<tr>
			<td title="">
					show_create_wewnetrzny
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_create_wewnetrzny" >
						<option value="" <?php echo !isset($pdf_show_create_wewnetrzny) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_create_wewnetrzny) && strrpos(",".$pdf_show_create_wewnetrzny.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_create_wewnetrzny" value="<?php echo $pdf_show_create_wewnetrzny ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
					Obl:<input type="checkbox" name="pob_show_create_wewnetrzny_obligatory" value="1" <?php echo $pob_show_create_wewnetrzny_obligatory == "1" ? " checked='checked' " : "" ?>/>
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_create_wewnetrzny" >
						<option value="" <?php echo !isset($pob_show_create_wewnetrzny) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_create_wewnetrzny) && strrpos(",".$pob_show_create_wewnetrzny.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_create_wewnetrzny" value="<?php echo $pob_show_create_wewnetrzny ?>">
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
			$values = array('show_create_korekta');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_korekta = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_korekta = $res;
			$values = array("show_create_korekta_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_korekta_obligatory = $res;
			$postValue = $_POST['pdf_show_create_korekta'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_create_korekta != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_create_korekta');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_create_korekta)) {
						$values = array($postValue, 'show_create_korekta');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_korekta, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_korekta');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_korekta = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_korekta = $res;
			$values = array("show_create_korekta_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_korekta_obligatory = $res;
			}
			$postValue = $_POST['pob_show_create_korekta'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_create_korekta != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_create_korekta');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_create_korekta)) {
						$values = array($postValue, 'show_create_korekta');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_korekta, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_korekta');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_korekta = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_korekta = $res;
			$values = array("show_create_korekta_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_korekta_obligatory = $res;
			}
			$postValue = $_POST['pob_show_create_korekta_obligatory'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_create_korekta_obligatory != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_create_korekta_obligatory');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_create_korekta_obligatory)) {
						$values = array($postValue, 'show_create_korekta_obligatory');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_korekta_obligatory, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_korekta_obligatory');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_korekta_obligatory = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_korekta_obligatory = $res;
			$values = array("show_create_korekta_obligatory_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_korekta_obligatory_obligatory = $res;
			}
?>
		<tr>
			<td title="">
					show_create_korekta
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_create_korekta" >
						<option value="" <?php echo !isset($pdf_show_create_korekta) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_create_korekta) && strrpos(",".$pdf_show_create_korekta.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_create_korekta" value="<?php echo $pdf_show_create_korekta ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
					Obl:<input type="checkbox" name="pob_show_create_korekta_obligatory" value="1" <?php echo $pob_show_create_korekta_obligatory == "1" ? " checked='checked' " : "" ?>/>
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_create_korekta" >
						<option value="" <?php echo !isset($pob_show_create_korekta) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_create_korekta) && strrpos(",".$pob_show_create_korekta.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_create_korekta" value="<?php echo $pob_show_create_korekta ?>">
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
			$values = array('show_create_zastepczy');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_zastepczy = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_zastepczy = $res;
			$values = array("show_create_zastepczy_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_zastepczy_obligatory = $res;
			$postValue = $_POST['pdf_show_create_zastepczy'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_create_zastepczy != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_create_zastepczy');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_create_zastepczy)) {
						$values = array($postValue, 'show_create_zastepczy');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_zastepczy, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_zastepczy');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_zastepczy = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_zastepczy = $res;
			$values = array("show_create_zastepczy_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_zastepczy_obligatory = $res;
			}
			$postValue = $_POST['pob_show_create_zastepczy'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_create_zastepczy != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_create_zastepczy');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_create_zastepczy)) {
						$values = array($postValue, 'show_create_zastepczy');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_zastepczy, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_zastepczy');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_zastepczy = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_zastepczy = $res;
			$values = array("show_create_zastepczy_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_zastepczy_obligatory = $res;
			}
			$postValue = $_POST['pob_show_create_zastepczy_obligatory'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_create_zastepczy_obligatory != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_create_zastepczy_obligatory');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_create_zastepczy_obligatory)) {
						$values = array($postValue, 'show_create_zastepczy_obligatory');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_zastepczy_obligatory, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_zastepczy_obligatory');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_zastepczy_obligatory = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_zastepczy_obligatory = $res;
			$values = array("show_create_zastepczy_obligatory_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_zastepczy_obligatory_obligatory = $res;
			}
?>
		<tr>
			<td title="">
					show_create_zastepczy
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_create_zastepczy" >
						<option value="" <?php echo !isset($pdf_show_create_zastepczy) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_create_zastepczy) && strrpos(",".$pdf_show_create_zastepczy.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_create_zastepczy" value="<?php echo $pdf_show_create_zastepczy ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
					Obl:<input type="checkbox" name="pob_show_create_zastepczy_obligatory" value="1" <?php echo $pob_show_create_zastepczy_obligatory == "1" ? " checked='checked' " : "" ?>/>
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_create_zastepczy" >
						<option value="" <?php echo !isset($pob_show_create_zastepczy) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_create_zastepczy) && strrpos(",".$pob_show_create_zastepczy.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_create_zastepczy" value="<?php echo $pob_show_create_zastepczy ?>">
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
			$values = array('show_create_ostatni_numer');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_ostatni_numer = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_ostatni_numer = $res;
			$values = array("show_create_ostatni_numer_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_ostatni_numer_obligatory = $res;
			$postValue = $_POST['pdf_show_create_ostatni_numer'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_create_ostatni_numer != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_create_ostatni_numer');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_create_ostatni_numer)) {
						$values = array($postValue, 'show_create_ostatni_numer');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_ostatni_numer, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_ostatni_numer');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_ostatni_numer = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_ostatni_numer = $res;
			$values = array("show_create_ostatni_numer_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_ostatni_numer_obligatory = $res;
			}
			$postValue = $_POST['pob_show_create_ostatni_numer'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_create_ostatni_numer != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_create_ostatni_numer');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_create_ostatni_numer)) {
						$values = array($postValue, 'show_create_ostatni_numer');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_ostatni_numer, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_ostatni_numer');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_ostatni_numer = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_ostatni_numer = $res;
			$values = array("show_create_ostatni_numer_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_ostatni_numer_obligatory = $res;
			}
			$postValue = $_POST['pob_show_create_ostatni_numer_obligatory'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_create_ostatni_numer_obligatory != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_create_ostatni_numer_obligatory');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_create_ostatni_numer_obligatory)) {
						$values = array($postValue, 'show_create_ostatni_numer_obligatory');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_ostatni_numer_obligatory, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_ostatni_numer_obligatory');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_ostatni_numer_obligatory = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_ostatni_numer_obligatory = $res;
			$values = array("show_create_ostatni_numer_obligatory_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_ostatni_numer_obligatory_obligatory = $res;
			}
?>
		<tr>
			<td title="">
					show_create_ostatni_numer
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_create_ostatni_numer" >
						<option value="" <?php echo !isset($pdf_show_create_ostatni_numer) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_create_ostatni_numer) && strrpos(",".$pdf_show_create_ostatni_numer.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_create_ostatni_numer" value="<?php echo $pdf_show_create_ostatni_numer ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
					Obl:<input type="checkbox" name="pob_show_create_ostatni_numer_obligatory" value="1" <?php echo $pob_show_create_ostatni_numer_obligatory == "1" ? " checked='checked' " : "" ?>/>
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_create_ostatni_numer" >
						<option value="" <?php echo !isset($pob_show_create_ostatni_numer) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_create_ostatni_numer) && strrpos(",".$pob_show_create_ostatni_numer.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_create_ostatni_numer" value="<?php echo $pob_show_create_ostatni_numer ?>">
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
			$values = array('show_create_numeracja_rok');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_numeracja_rok = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_numeracja_rok = $res;
			$values = array("show_create_numeracja_rok_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_numeracja_rok_obligatory = $res;
			$postValue = $_POST['pdf_show_create_numeracja_rok'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_create_numeracja_rok != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_create_numeracja_rok');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_create_numeracja_rok)) {
						$values = array($postValue, 'show_create_numeracja_rok');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_numeracja_rok, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_numeracja_rok');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_numeracja_rok = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_numeracja_rok = $res;
			$values = array("show_create_numeracja_rok_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_numeracja_rok_obligatory = $res;
			}
			$postValue = $_POST['pob_show_create_numeracja_rok'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_create_numeracja_rok != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_create_numeracja_rok');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_create_numeracja_rok)) {
						$values = array($postValue, 'show_create_numeracja_rok');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_numeracja_rok, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_numeracja_rok');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_numeracja_rok = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_numeracja_rok = $res;
			$values = array("show_create_numeracja_rok_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_numeracja_rok_obligatory = $res;
			}
			$postValue = $_POST['pob_show_create_numeracja_rok_obligatory'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_create_numeracja_rok_obligatory != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_create_numeracja_rok_obligatory');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_create_numeracja_rok_obligatory)) {
						$values = array($postValue, 'show_create_numeracja_rok_obligatory');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_numeracja_rok_obligatory, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_numeracja_rok_obligatory');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_numeracja_rok_obligatory = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_numeracja_rok_obligatory = $res;
			$values = array("show_create_numeracja_rok_obligatory_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_numeracja_rok_obligatory_obligatory = $res;
			}
?>
		<tr>
			<td title="">
					show_create_numeracja_rok
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_create_numeracja_rok" >
						<option value="" <?php echo !isset($pdf_show_create_numeracja_rok) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_create_numeracja_rok) && strrpos(",".$pdf_show_create_numeracja_rok.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_create_numeracja_rok" value="<?php echo $pdf_show_create_numeracja_rok ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
					Obl:<input type="checkbox" name="pob_show_create_numeracja_rok_obligatory" value="1" <?php echo $pob_show_create_numeracja_rok_obligatory == "1" ? " checked='checked' " : "" ?>/>
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_create_numeracja_rok" >
						<option value="" <?php echo !isset($pob_show_create_numeracja_rok) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_create_numeracja_rok) && strrpos(",".$pob_show_create_numeracja_rok.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_create_numeracja_rok" value="<?php echo $pob_show_create_numeracja_rok ?>">
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
<?php
			$options = array();
			$options["0"] = "Hide";
			$options["2"] = "Read";
			$options["1"] = "Change";
			$options["3"] = "Change Ajax";
?>
<?php
			$types = "s";
			$values = array('show_create_grupa_dokumentow');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_grupa_dokumentow = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_grupa_dokumentow = $res;
			$postValue = $_POST['pdf_show_create_grupa_dokumentow'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_create_grupa_dokumentow != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_create_grupa_dokumentow');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_create_grupa_dokumentow)) {
						$values = array($postValue, 'show_create_grupa_dokumentow');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_grupa_dokumentow, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_grupa_dokumentow');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_grupa_dokumentow = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_grupa_dokumentow = $res;
			}
			$postValue = $_POST['pob_show_create_grupa_dokumentow'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_create_grupa_dokumentow != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_create_grupa_dokumentow');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_create_grupa_dokumentow)) {
						$values = array($postValue, 'show_create_grupa_dokumentow');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_grupa_dokumentow, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_grupa_dokumentow');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_grupa_dokumentow = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_grupa_dokumentow = $res;
			}
?>
		<tr>
			<td title="">
					show_create_grupa_dokumentow
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_create_grupa_dokumentow" >
						<option value="" <?php echo !isset($pdf_show_create_grupa_dokumentow) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_create_grupa_dokumentow) && strrpos(",".$pdf_show_create_grupa_dokumentow.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_create_grupa_dokumentow" value="<?php echo $pdf_show_create_grupa_dokumentow ?>">
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
					<select name="pob_show_create_grupa_dokumentow" >
						<option value="" <?php echo !isset($pob_show_create_grupa_dokumentow) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_create_grupa_dokumentow) && strrpos(",".$pob_show_create_grupa_dokumentow.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_create_grupa_dokumentow" value="<?php echo $pob_show_create_grupa_dokumentow ?>">
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
			$options[-2] = "Encrypted id from request";
			$options[-1] = "record created by logged in user";
			$query = <<<SQL
SELECT 
  gdk_id,
  gdk_virgo_title
FROM 
  slk_grupy_dokumentow
SQL;
			$result = $databaseHandler->query($query);
			while ($row = mysqli_fetch_row($result)) {
				$options[$row[0]] = "{$row[1]}";
			}
			mysqli_free_result($result);			
?>
<?php
			$types = "s";
			$values = array('create_default_value_grupa_dokumentow');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_create_default_value_grupa_dokumentow = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_create_default_value_grupa_dokumentow = $res;
			$postValue = $_POST['pdf_create_default_value_grupa_dokumentow'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_create_default_value_grupa_dokumentow != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('create_default_value_grupa_dokumentow');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_create_default_value_grupa_dokumentow)) {
						$values = array($postValue, 'create_default_value_grupa_dokumentow');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(create_default_value_grupa_dokumentow, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('create_default_value_grupa_dokumentow');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_create_default_value_grupa_dokumentow = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_create_default_value_grupa_dokumentow = $res;
			}
			$postValue = $_POST['pob_create_default_value_grupa_dokumentow'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_create_default_value_grupa_dokumentow != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('create_default_value_grupa_dokumentow');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_create_default_value_grupa_dokumentow)) {
						$values = array($postValue, 'create_default_value_grupa_dokumentow');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(create_default_value_grupa_dokumentow, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('create_default_value_grupa_dokumentow');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_create_default_value_grupa_dokumentow = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_create_default_value_grupa_dokumentow = $res;
			}
?>
		<tr>
			<td title="">
					create_default_value_grupa_dokumentow
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_create_default_value_grupa_dokumentow" >
						<option value="" <?php echo !isset($pdf_create_default_value_grupa_dokumentow) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_create_default_value_grupa_dokumentow) && strrpos(",".$pdf_create_default_value_grupa_dokumentow.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_create_default_value_grupa_dokumentow" value="<?php echo $pdf_create_default_value_grupa_dokumentow ?>">
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
					<select name="pob_create_default_value_grupa_dokumentow" >
						<option value="" <?php echo !isset($pob_create_default_value_grupa_dokumentow) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_create_default_value_grupa_dokumentow) && strrpos(",".$pob_create_default_value_grupa_dokumentow.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_create_default_value_grupa_dokumentow" value="<?php echo $pob_create_default_value_grupa_dokumentow ?>">
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
<?php
			$options = array();
			$options["0"] = "No";
			$options["1"] = "Yes";
?>
<?php
			$types = "s";
			$values = array('show_create_dokumenty_ksiegowe');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_dokumenty_ksiegowe = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_dokumenty_ksiegowe = $res;
			$postValue = $_POST['pdf_show_create_dokumenty_ksiegowe'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_create_dokumenty_ksiegowe != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_create_dokumenty_ksiegowe');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_create_dokumenty_ksiegowe)) {
						$values = array($postValue, 'show_create_dokumenty_ksiegowe');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_dokumenty_ksiegowe, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_dokumenty_ksiegowe');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_dokumenty_ksiegowe = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_dokumenty_ksiegowe = $res;
			}
			$postValue = $_POST['pob_show_create_dokumenty_ksiegowe'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_create_dokumenty_ksiegowe != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_create_dokumenty_ksiegowe');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_create_dokumenty_ksiegowe)) {
						$values = array($postValue, 'show_create_dokumenty_ksiegowe');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_dokumenty_ksiegowe, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_dokumenty_ksiegowe');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_dokumenty_ksiegowe = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_dokumenty_ksiegowe = $res;
			}
?>
		<tr>
			<td title="">
					show_create_dokumenty_ksiegowe
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_create_dokumenty_ksiegowe" >
						<option value="" <?php echo !isset($pdf_show_create_dokumenty_ksiegowe) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_create_dokumenty_ksiegowe) && strrpos(",".$pdf_show_create_dokumenty_ksiegowe.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_create_dokumenty_ksiegowe" value="<?php echo $pdf_show_create_dokumenty_ksiegowe ?>">
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
					<select name="pob_show_create_dokumenty_ksiegowe" >
						<option value="" <?php echo !isset($pob_show_create_dokumenty_ksiegowe) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_create_dokumenty_ksiegowe) && strrpos(",".$pob_show_create_dokumenty_ksiegowe.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_create_dokumenty_ksiegowe" value="<?php echo $pob_show_create_dokumenty_ksiegowe ?>">
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
			$values = array('show_form_nazwa');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_nazwa = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_nazwa = $res;
			$values = array("show_form_nazwa_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_nazwa_obligatory = $res;
			$postValue = $_POST['pdf_show_form_nazwa'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_form_nazwa != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_form_nazwa');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_form_nazwa)) {
						$values = array($postValue, 'show_form_nazwa');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_nazwa, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_nazwa');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_nazwa = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_nazwa = $res;
			$values = array("show_form_nazwa_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_nazwa_obligatory = $res;
			}
			$postValue = $_POST['pob_show_form_nazwa'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_form_nazwa != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_form_nazwa');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_form_nazwa)) {
						$values = array($postValue, 'show_form_nazwa');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_nazwa, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_nazwa');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_nazwa = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_nazwa = $res;
			$values = array("show_form_nazwa_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_nazwa_obligatory = $res;
			}
			$postValue = $_POST['pob_show_form_nazwa_obligatory'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_form_nazwa_obligatory != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_form_nazwa_obligatory');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_form_nazwa_obligatory)) {
						$values = array($postValue, 'show_form_nazwa_obligatory');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_nazwa_obligatory, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_nazwa_obligatory');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_nazwa_obligatory = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_nazwa_obligatory = $res;
			$values = array("show_form_nazwa_obligatory_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_nazwa_obligatory_obligatory = $res;
			}
?>
		<tr>
			<td title="">
					show_form_nazwa
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_form_nazwa" >
						<option value="" <?php echo !isset($pdf_show_form_nazwa) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_form_nazwa) && strrpos(",".$pdf_show_form_nazwa.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_form_nazwa" value="<?php echo $pdf_show_form_nazwa ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
					Obl:<input type="checkbox" name="pob_show_form_nazwa_obligatory" value="1" <?php echo $pob_show_form_nazwa_obligatory == "1" ? " checked='checked' " : "" ?>/>
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_form_nazwa" >
						<option value="" <?php echo !isset($pob_show_form_nazwa) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_form_nazwa) && strrpos(",".$pob_show_form_nazwa.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_form_nazwa" value="<?php echo $pob_show_form_nazwa ?>">
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
			$values = array('show_form_symbol');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_symbol = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_symbol = $res;
			$postValue = $_POST['pdf_show_form_symbol'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_form_symbol != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_form_symbol');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_form_symbol)) {
						$values = array($postValue, 'show_form_symbol');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_symbol, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_symbol');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_symbol = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_symbol = $res;
			}
			$postValue = $_POST['pob_show_form_symbol'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_form_symbol != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_form_symbol');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_form_symbol)) {
						$values = array($postValue, 'show_form_symbol');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_symbol, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_symbol');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_symbol = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_symbol = $res;
			}
?>
		<tr>
			<td title="">
				<strong>
					show_form_symbol
				</strong>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_form_symbol" >
						<option value="" <?php echo !isset($pdf_show_form_symbol) ? "selected " : "" ?>>!!!OBLIGATORY!!!</option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_form_symbol) && strrpos(",".$pdf_show_form_symbol.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_form_symbol" value="<?php echo $pdf_show_form_symbol ?>">
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
					<select name="pob_show_form_symbol" >
						<option value="" <?php echo !isset($pob_show_form_symbol) ? "selected " : "" ?>>!!!OBLIGATORY!!!</option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_form_symbol) && strrpos(",".$pob_show_form_symbol.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_form_symbol" value="<?php echo $pob_show_form_symbol ?>">
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
			$values = array('show_form_zwiekszajacy');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_zwiekszajacy = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_zwiekszajacy = $res;
			$values = array("show_form_zwiekszajacy_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_zwiekszajacy_obligatory = $res;
			$postValue = $_POST['pdf_show_form_zwiekszajacy'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_form_zwiekszajacy != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_form_zwiekszajacy');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_form_zwiekszajacy)) {
						$values = array($postValue, 'show_form_zwiekszajacy');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_zwiekszajacy, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_zwiekszajacy');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_zwiekszajacy = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_zwiekszajacy = $res;
			$values = array("show_form_zwiekszajacy_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_zwiekszajacy_obligatory = $res;
			}
			$postValue = $_POST['pob_show_form_zwiekszajacy'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_form_zwiekszajacy != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_form_zwiekszajacy');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_form_zwiekszajacy)) {
						$values = array($postValue, 'show_form_zwiekszajacy');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_zwiekszajacy, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_zwiekszajacy');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_zwiekszajacy = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_zwiekszajacy = $res;
			$values = array("show_form_zwiekszajacy_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_zwiekszajacy_obligatory = $res;
			}
			$postValue = $_POST['pob_show_form_zwiekszajacy_obligatory'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_form_zwiekszajacy_obligatory != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_form_zwiekszajacy_obligatory');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_form_zwiekszajacy_obligatory)) {
						$values = array($postValue, 'show_form_zwiekszajacy_obligatory');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_zwiekszajacy_obligatory, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_zwiekszajacy_obligatory');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_zwiekszajacy_obligatory = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_zwiekszajacy_obligatory = $res;
			$values = array("show_form_zwiekszajacy_obligatory_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_zwiekszajacy_obligatory_obligatory = $res;
			}
?>
		<tr>
			<td title="">
					show_form_zwiekszajacy
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_form_zwiekszajacy" >
						<option value="" <?php echo !isset($pdf_show_form_zwiekszajacy) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_form_zwiekszajacy) && strrpos(",".$pdf_show_form_zwiekszajacy.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_form_zwiekszajacy" value="<?php echo $pdf_show_form_zwiekszajacy ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
					Obl:<input type="checkbox" name="pob_show_form_zwiekszajacy_obligatory" value="1" <?php echo $pob_show_form_zwiekszajacy_obligatory == "1" ? " checked='checked' " : "" ?>/>
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_form_zwiekszajacy" >
						<option value="" <?php echo !isset($pob_show_form_zwiekszajacy) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_form_zwiekszajacy) && strrpos(",".$pob_show_form_zwiekszajacy.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_form_zwiekszajacy" value="<?php echo $pob_show_form_zwiekszajacy ?>">
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
			$values = array('show_form_wlasny');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_wlasny = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_wlasny = $res;
			$values = array("show_form_wlasny_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_wlasny_obligatory = $res;
			$postValue = $_POST['pdf_show_form_wlasny'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_form_wlasny != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_form_wlasny');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_form_wlasny)) {
						$values = array($postValue, 'show_form_wlasny');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_wlasny, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_wlasny');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_wlasny = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_wlasny = $res;
			$values = array("show_form_wlasny_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_wlasny_obligatory = $res;
			}
			$postValue = $_POST['pob_show_form_wlasny'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_form_wlasny != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_form_wlasny');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_form_wlasny)) {
						$values = array($postValue, 'show_form_wlasny');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_wlasny, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_wlasny');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_wlasny = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_wlasny = $res;
			$values = array("show_form_wlasny_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_wlasny_obligatory = $res;
			}
			$postValue = $_POST['pob_show_form_wlasny_obligatory'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_form_wlasny_obligatory != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_form_wlasny_obligatory');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_form_wlasny_obligatory)) {
						$values = array($postValue, 'show_form_wlasny_obligatory');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_wlasny_obligatory, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_wlasny_obligatory');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_wlasny_obligatory = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_wlasny_obligatory = $res;
			$values = array("show_form_wlasny_obligatory_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_wlasny_obligatory_obligatory = $res;
			}
?>
		<tr>
			<td title="">
					show_form_wlasny
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_form_wlasny" >
						<option value="" <?php echo !isset($pdf_show_form_wlasny) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_form_wlasny) && strrpos(",".$pdf_show_form_wlasny.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_form_wlasny" value="<?php echo $pdf_show_form_wlasny ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
					Obl:<input type="checkbox" name="pob_show_form_wlasny_obligatory" value="1" <?php echo $pob_show_form_wlasny_obligatory == "1" ? " checked='checked' " : "" ?>/>
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_form_wlasny" >
						<option value="" <?php echo !isset($pob_show_form_wlasny) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_form_wlasny) && strrpos(",".$pob_show_form_wlasny.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_form_wlasny" value="<?php echo $pob_show_form_wlasny ?>">
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
			$values = array('show_form_wewnetrzny');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_wewnetrzny = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_wewnetrzny = $res;
			$values = array("show_form_wewnetrzny_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_wewnetrzny_obligatory = $res;
			$postValue = $_POST['pdf_show_form_wewnetrzny'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_form_wewnetrzny != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_form_wewnetrzny');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_form_wewnetrzny)) {
						$values = array($postValue, 'show_form_wewnetrzny');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_wewnetrzny, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_wewnetrzny');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_wewnetrzny = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_wewnetrzny = $res;
			$values = array("show_form_wewnetrzny_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_wewnetrzny_obligatory = $res;
			}
			$postValue = $_POST['pob_show_form_wewnetrzny'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_form_wewnetrzny != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_form_wewnetrzny');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_form_wewnetrzny)) {
						$values = array($postValue, 'show_form_wewnetrzny');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_wewnetrzny, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_wewnetrzny');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_wewnetrzny = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_wewnetrzny = $res;
			$values = array("show_form_wewnetrzny_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_wewnetrzny_obligatory = $res;
			}
			$postValue = $_POST['pob_show_form_wewnetrzny_obligatory'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_form_wewnetrzny_obligatory != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_form_wewnetrzny_obligatory');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_form_wewnetrzny_obligatory)) {
						$values = array($postValue, 'show_form_wewnetrzny_obligatory');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_wewnetrzny_obligatory, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_wewnetrzny_obligatory');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_wewnetrzny_obligatory = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_wewnetrzny_obligatory = $res;
			$values = array("show_form_wewnetrzny_obligatory_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_wewnetrzny_obligatory_obligatory = $res;
			}
?>
		<tr>
			<td title="">
					show_form_wewnetrzny
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_form_wewnetrzny" >
						<option value="" <?php echo !isset($pdf_show_form_wewnetrzny) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_form_wewnetrzny) && strrpos(",".$pdf_show_form_wewnetrzny.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_form_wewnetrzny" value="<?php echo $pdf_show_form_wewnetrzny ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
					Obl:<input type="checkbox" name="pob_show_form_wewnetrzny_obligatory" value="1" <?php echo $pob_show_form_wewnetrzny_obligatory == "1" ? " checked='checked' " : "" ?>/>
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_form_wewnetrzny" >
						<option value="" <?php echo !isset($pob_show_form_wewnetrzny) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_form_wewnetrzny) && strrpos(",".$pob_show_form_wewnetrzny.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_form_wewnetrzny" value="<?php echo $pob_show_form_wewnetrzny ?>">
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
			$values = array('show_form_korekta');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_korekta = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_korekta = $res;
			$values = array("show_form_korekta_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_korekta_obligatory = $res;
			$postValue = $_POST['pdf_show_form_korekta'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_form_korekta != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_form_korekta');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_form_korekta)) {
						$values = array($postValue, 'show_form_korekta');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_korekta, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_korekta');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_korekta = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_korekta = $res;
			$values = array("show_form_korekta_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_korekta_obligatory = $res;
			}
			$postValue = $_POST['pob_show_form_korekta'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_form_korekta != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_form_korekta');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_form_korekta)) {
						$values = array($postValue, 'show_form_korekta');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_korekta, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_korekta');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_korekta = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_korekta = $res;
			$values = array("show_form_korekta_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_korekta_obligatory = $res;
			}
			$postValue = $_POST['pob_show_form_korekta_obligatory'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_form_korekta_obligatory != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_form_korekta_obligatory');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_form_korekta_obligatory)) {
						$values = array($postValue, 'show_form_korekta_obligatory');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_korekta_obligatory, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_korekta_obligatory');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_korekta_obligatory = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_korekta_obligatory = $res;
			$values = array("show_form_korekta_obligatory_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_korekta_obligatory_obligatory = $res;
			}
?>
		<tr>
			<td title="">
					show_form_korekta
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_form_korekta" >
						<option value="" <?php echo !isset($pdf_show_form_korekta) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_form_korekta) && strrpos(",".$pdf_show_form_korekta.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_form_korekta" value="<?php echo $pdf_show_form_korekta ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
					Obl:<input type="checkbox" name="pob_show_form_korekta_obligatory" value="1" <?php echo $pob_show_form_korekta_obligatory == "1" ? " checked='checked' " : "" ?>/>
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_form_korekta" >
						<option value="" <?php echo !isset($pob_show_form_korekta) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_form_korekta) && strrpos(",".$pob_show_form_korekta.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_form_korekta" value="<?php echo $pob_show_form_korekta ?>">
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
			$values = array('show_form_zastepczy');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_zastepczy = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_zastepczy = $res;
			$values = array("show_form_zastepczy_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_zastepczy_obligatory = $res;
			$postValue = $_POST['pdf_show_form_zastepczy'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_form_zastepczy != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_form_zastepczy');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_form_zastepczy)) {
						$values = array($postValue, 'show_form_zastepczy');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_zastepczy, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_zastepczy');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_zastepczy = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_zastepczy = $res;
			$values = array("show_form_zastepczy_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_zastepczy_obligatory = $res;
			}
			$postValue = $_POST['pob_show_form_zastepczy'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_form_zastepczy != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_form_zastepczy');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_form_zastepczy)) {
						$values = array($postValue, 'show_form_zastepczy');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_zastepczy, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_zastepczy');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_zastepczy = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_zastepczy = $res;
			$values = array("show_form_zastepczy_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_zastepczy_obligatory = $res;
			}
			$postValue = $_POST['pob_show_form_zastepczy_obligatory'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_form_zastepczy_obligatory != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_form_zastepczy_obligatory');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_form_zastepczy_obligatory)) {
						$values = array($postValue, 'show_form_zastepczy_obligatory');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_zastepczy_obligatory, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_zastepczy_obligatory');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_zastepczy_obligatory = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_zastepczy_obligatory = $res;
			$values = array("show_form_zastepczy_obligatory_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_zastepczy_obligatory_obligatory = $res;
			}
?>
		<tr>
			<td title="">
					show_form_zastepczy
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_form_zastepczy" >
						<option value="" <?php echo !isset($pdf_show_form_zastepczy) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_form_zastepczy) && strrpos(",".$pdf_show_form_zastepczy.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_form_zastepczy" value="<?php echo $pdf_show_form_zastepczy ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
					Obl:<input type="checkbox" name="pob_show_form_zastepczy_obligatory" value="1" <?php echo $pob_show_form_zastepczy_obligatory == "1" ? " checked='checked' " : "" ?>/>
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_form_zastepczy" >
						<option value="" <?php echo !isset($pob_show_form_zastepczy) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_form_zastepczy) && strrpos(",".$pob_show_form_zastepczy.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_form_zastepczy" value="<?php echo $pob_show_form_zastepczy ?>">
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
			$values = array('show_form_ostatni_numer');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_ostatni_numer = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_ostatni_numer = $res;
			$values = array("show_form_ostatni_numer_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_ostatni_numer_obligatory = $res;
			$postValue = $_POST['pdf_show_form_ostatni_numer'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_form_ostatni_numer != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_form_ostatni_numer');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_form_ostatni_numer)) {
						$values = array($postValue, 'show_form_ostatni_numer');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_ostatni_numer, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_ostatni_numer');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_ostatni_numer = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_ostatni_numer = $res;
			$values = array("show_form_ostatni_numer_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_ostatni_numer_obligatory = $res;
			}
			$postValue = $_POST['pob_show_form_ostatni_numer'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_form_ostatni_numer != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_form_ostatni_numer');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_form_ostatni_numer)) {
						$values = array($postValue, 'show_form_ostatni_numer');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_ostatni_numer, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_ostatni_numer');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_ostatni_numer = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_ostatni_numer = $res;
			$values = array("show_form_ostatni_numer_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_ostatni_numer_obligatory = $res;
			}
			$postValue = $_POST['pob_show_form_ostatni_numer_obligatory'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_form_ostatni_numer_obligatory != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_form_ostatni_numer_obligatory');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_form_ostatni_numer_obligatory)) {
						$values = array($postValue, 'show_form_ostatni_numer_obligatory');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_ostatni_numer_obligatory, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_ostatni_numer_obligatory');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_ostatni_numer_obligatory = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_ostatni_numer_obligatory = $res;
			$values = array("show_form_ostatni_numer_obligatory_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_ostatni_numer_obligatory_obligatory = $res;
			}
?>
		<tr>
			<td title="">
					show_form_ostatni_numer
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_form_ostatni_numer" >
						<option value="" <?php echo !isset($pdf_show_form_ostatni_numer) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_form_ostatni_numer) && strrpos(",".$pdf_show_form_ostatni_numer.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_form_ostatni_numer" value="<?php echo $pdf_show_form_ostatni_numer ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
					Obl:<input type="checkbox" name="pob_show_form_ostatni_numer_obligatory" value="1" <?php echo $pob_show_form_ostatni_numer_obligatory == "1" ? " checked='checked' " : "" ?>/>
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_form_ostatni_numer" >
						<option value="" <?php echo !isset($pob_show_form_ostatni_numer) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_form_ostatni_numer) && strrpos(",".$pob_show_form_ostatni_numer.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_form_ostatni_numer" value="<?php echo $pob_show_form_ostatni_numer ?>">
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
			$values = array('show_form_numeracja_rok');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_numeracja_rok = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_numeracja_rok = $res;
			$values = array("show_form_numeracja_rok_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_numeracja_rok_obligatory = $res;
			$postValue = $_POST['pdf_show_form_numeracja_rok'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_form_numeracja_rok != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_form_numeracja_rok');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_form_numeracja_rok)) {
						$values = array($postValue, 'show_form_numeracja_rok');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_numeracja_rok, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_numeracja_rok');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_numeracja_rok = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_numeracja_rok = $res;
			$values = array("show_form_numeracja_rok_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_numeracja_rok_obligatory = $res;
			}
			$postValue = $_POST['pob_show_form_numeracja_rok'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_form_numeracja_rok != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_form_numeracja_rok');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_form_numeracja_rok)) {
						$values = array($postValue, 'show_form_numeracja_rok');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_numeracja_rok, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_numeracja_rok');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_numeracja_rok = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_numeracja_rok = $res;
			$values = array("show_form_numeracja_rok_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_numeracja_rok_obligatory = $res;
			}
			$postValue = $_POST['pob_show_form_numeracja_rok_obligatory'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_form_numeracja_rok_obligatory != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_form_numeracja_rok_obligatory');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_form_numeracja_rok_obligatory)) {
						$values = array($postValue, 'show_form_numeracja_rok_obligatory');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_numeracja_rok_obligatory, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_numeracja_rok_obligatory');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_numeracja_rok_obligatory = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_numeracja_rok_obligatory = $res;
			$values = array("show_form_numeracja_rok_obligatory_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_numeracja_rok_obligatory_obligatory = $res;
			}
?>
		<tr>
			<td title="">
					show_form_numeracja_rok
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_form_numeracja_rok" >
						<option value="" <?php echo !isset($pdf_show_form_numeracja_rok) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_form_numeracja_rok) && strrpos(",".$pdf_show_form_numeracja_rok.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_form_numeracja_rok" value="<?php echo $pdf_show_form_numeracja_rok ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
					Obl:<input type="checkbox" name="pob_show_form_numeracja_rok_obligatory" value="1" <?php echo $pob_show_form_numeracja_rok_obligatory == "1" ? " checked='checked' " : "" ?>/>
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_form_numeracja_rok" >
						<option value="" <?php echo !isset($pob_show_form_numeracja_rok) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_form_numeracja_rok) && strrpos(",".$pob_show_form_numeracja_rok.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_form_numeracja_rok" value="<?php echo $pob_show_form_numeracja_rok ?>">
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
<?php
			$types = "s";
			$values = array('show_form_grupa_dokumentow');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_grupa_dokumentow = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_grupa_dokumentow = $res;
			$postValue = $_POST['pdf_show_form_grupa_dokumentow'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_form_grupa_dokumentow != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_form_grupa_dokumentow');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_form_grupa_dokumentow)) {
						$values = array($postValue, 'show_form_grupa_dokumentow');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_grupa_dokumentow, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_grupa_dokumentow');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_grupa_dokumentow = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_grupa_dokumentow = $res;
			}
			$postValue = $_POST['pob_show_form_grupa_dokumentow'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_form_grupa_dokumentow != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_form_grupa_dokumentow');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_form_grupa_dokumentow)) {
						$values = array($postValue, 'show_form_grupa_dokumentow');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_grupa_dokumentow, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_grupa_dokumentow');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_grupa_dokumentow = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_grupa_dokumentow = $res;
			}
?>
		<tr>
			<td title="">
					show_form_grupa_dokumentow
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_form_grupa_dokumentow" >
						<option value="" <?php echo !isset($pdf_show_form_grupa_dokumentow) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_form_grupa_dokumentow) && strrpos(",".$pdf_show_form_grupa_dokumentow.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_form_grupa_dokumentow" value="<?php echo $pdf_show_form_grupa_dokumentow ?>">
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
					<select name="pob_show_form_grupa_dokumentow" >
						<option value="" <?php echo !isset($pob_show_form_grupa_dokumentow) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_form_grupa_dokumentow) && strrpos(",".$pob_show_form_grupa_dokumentow.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_form_grupa_dokumentow" value="<?php echo $pob_show_form_grupa_dokumentow ?>">
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
<?php
			$options = array();
			$options["0"] = "No";
			$options["1"] = "Yes";
?>
<?php
			$types = "s";
			$values = array('show_form_dokumenty_ksiegowe');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_dokumenty_ksiegowe = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_dokumenty_ksiegowe = $res;
			$postValue = $_POST['pdf_show_form_dokumenty_ksiegowe'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_form_dokumenty_ksiegowe != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_form_dokumenty_ksiegowe');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_form_dokumenty_ksiegowe)) {
						$values = array($postValue, 'show_form_dokumenty_ksiegowe');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_dokumenty_ksiegowe, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_dokumenty_ksiegowe');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_dokumenty_ksiegowe = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_dokumenty_ksiegowe = $res;
			}
			$postValue = $_POST['pob_show_form_dokumenty_ksiegowe'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_form_dokumenty_ksiegowe != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_form_dokumenty_ksiegowe');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_form_dokumenty_ksiegowe)) {
						$values = array($postValue, 'show_form_dokumenty_ksiegowe');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_dokumenty_ksiegowe, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_dokumenty_ksiegowe');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_dokumenty_ksiegowe = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_dokumenty_ksiegowe = $res;
			}
?>
		<tr>
			<td title="">
					show_form_dokumenty_ksiegowe
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_form_dokumenty_ksiegowe" >
						<option value="" <?php echo !isset($pdf_show_form_dokumenty_ksiegowe) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_form_dokumenty_ksiegowe) && strrpos(",".$pdf_show_form_dokumenty_ksiegowe.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_form_dokumenty_ksiegowe" value="<?php echo $pdf_show_form_dokumenty_ksiegowe ?>">
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
					<select name="pob_show_form_dokumenty_ksiegowe" >
						<option value="" <?php echo !isset($pob_show_form_dokumenty_ksiegowe) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_form_dokumenty_ksiegowe) && strrpos(",".$pob_show_form_dokumenty_ksiegowe.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_form_dokumenty_ksiegowe" value="<?php echo $pob_show_form_dokumenty_ksiegowe ?>">
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
			$values = array('show_view_nazwa');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_nazwa = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_nazwa = $res;
			$postValue = $_POST['pdf_show_view_nazwa'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_view_nazwa != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_view_nazwa');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_view_nazwa)) {
						$values = array($postValue, 'show_view_nazwa');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_view_nazwa, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_view_nazwa');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_nazwa = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_nazwa = $res;
			}
			$postValue = $_POST['pob_show_view_nazwa'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_view_nazwa != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_view_nazwa');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_view_nazwa)) {
						$values = array($postValue, 'show_view_nazwa');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_view_nazwa, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_view_nazwa');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_nazwa = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_nazwa = $res;
			}
?>
		<tr>
			<td title="">
					show_view_nazwa
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_view_nazwa" >
						<option value="" <?php echo !isset($pdf_show_view_nazwa) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_view_nazwa) && strrpos(",".$pdf_show_view_nazwa.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_view_nazwa" value="<?php echo $pdf_show_view_nazwa ?>">
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
					<select name="pob_show_view_nazwa" >
						<option value="" <?php echo !isset($pob_show_view_nazwa) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_view_nazwa) && strrpos(",".$pob_show_view_nazwa.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_view_nazwa" value="<?php echo $pob_show_view_nazwa ?>">
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
			$values = array('show_view_symbol');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_symbol = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_symbol = $res;
			$postValue = $_POST['pdf_show_view_symbol'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_view_symbol != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_view_symbol');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_view_symbol)) {
						$values = array($postValue, 'show_view_symbol');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_view_symbol, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_view_symbol');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_symbol = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_symbol = $res;
			}
			$postValue = $_POST['pob_show_view_symbol'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_view_symbol != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_view_symbol');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_view_symbol)) {
						$values = array($postValue, 'show_view_symbol');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_view_symbol, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_view_symbol');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_symbol = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_symbol = $res;
			}
?>
		<tr>
			<td title="">
				<strong>
					show_view_symbol
				</strong>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_view_symbol" >
						<option value="" <?php echo !isset($pdf_show_view_symbol) ? "selected " : "" ?>>!!!OBLIGATORY!!!</option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_view_symbol) && strrpos(",".$pdf_show_view_symbol.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_view_symbol" value="<?php echo $pdf_show_view_symbol ?>">
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
					<select name="pob_show_view_symbol" >
						<option value="" <?php echo !isset($pob_show_view_symbol) ? "selected " : "" ?>>!!!OBLIGATORY!!!</option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_view_symbol) && strrpos(",".$pob_show_view_symbol.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_view_symbol" value="<?php echo $pob_show_view_symbol ?>">
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
			$values = array('show_view_zwiekszajacy');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_zwiekszajacy = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_zwiekszajacy = $res;
			$postValue = $_POST['pdf_show_view_zwiekszajacy'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_view_zwiekszajacy != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_view_zwiekszajacy');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_view_zwiekszajacy)) {
						$values = array($postValue, 'show_view_zwiekszajacy');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_view_zwiekszajacy, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_view_zwiekszajacy');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_zwiekszajacy = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_zwiekszajacy = $res;
			}
			$postValue = $_POST['pob_show_view_zwiekszajacy'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_view_zwiekszajacy != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_view_zwiekszajacy');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_view_zwiekszajacy)) {
						$values = array($postValue, 'show_view_zwiekszajacy');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_view_zwiekszajacy, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_view_zwiekszajacy');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_zwiekszajacy = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_zwiekszajacy = $res;
			}
?>
		<tr>
			<td title="">
					show_view_zwiekszajacy
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_view_zwiekszajacy" >
						<option value="" <?php echo !isset($pdf_show_view_zwiekszajacy) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_view_zwiekszajacy) && strrpos(",".$pdf_show_view_zwiekszajacy.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_view_zwiekszajacy" value="<?php echo $pdf_show_view_zwiekszajacy ?>">
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
					<select name="pob_show_view_zwiekszajacy" >
						<option value="" <?php echo !isset($pob_show_view_zwiekszajacy) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_view_zwiekszajacy) && strrpos(",".$pob_show_view_zwiekszajacy.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_view_zwiekszajacy" value="<?php echo $pob_show_view_zwiekszajacy ?>">
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
			$values = array('show_view_wlasny');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_wlasny = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_wlasny = $res;
			$postValue = $_POST['pdf_show_view_wlasny'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_view_wlasny != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_view_wlasny');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_view_wlasny)) {
						$values = array($postValue, 'show_view_wlasny');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_view_wlasny, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_view_wlasny');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_wlasny = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_wlasny = $res;
			}
			$postValue = $_POST['pob_show_view_wlasny'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_view_wlasny != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_view_wlasny');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_view_wlasny)) {
						$values = array($postValue, 'show_view_wlasny');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_view_wlasny, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_view_wlasny');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_wlasny = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_wlasny = $res;
			}
?>
		<tr>
			<td title="">
					show_view_wlasny
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_view_wlasny" >
						<option value="" <?php echo !isset($pdf_show_view_wlasny) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_view_wlasny) && strrpos(",".$pdf_show_view_wlasny.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_view_wlasny" value="<?php echo $pdf_show_view_wlasny ?>">
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
					<select name="pob_show_view_wlasny" >
						<option value="" <?php echo !isset($pob_show_view_wlasny) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_view_wlasny) && strrpos(",".$pob_show_view_wlasny.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_view_wlasny" value="<?php echo $pob_show_view_wlasny ?>">
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
			$values = array('show_view_wewnetrzny');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_wewnetrzny = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_wewnetrzny = $res;
			$postValue = $_POST['pdf_show_view_wewnetrzny'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_view_wewnetrzny != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_view_wewnetrzny');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_view_wewnetrzny)) {
						$values = array($postValue, 'show_view_wewnetrzny');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_view_wewnetrzny, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_view_wewnetrzny');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_wewnetrzny = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_wewnetrzny = $res;
			}
			$postValue = $_POST['pob_show_view_wewnetrzny'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_view_wewnetrzny != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_view_wewnetrzny');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_view_wewnetrzny)) {
						$values = array($postValue, 'show_view_wewnetrzny');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_view_wewnetrzny, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_view_wewnetrzny');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_wewnetrzny = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_wewnetrzny = $res;
			}
?>
		<tr>
			<td title="">
					show_view_wewnetrzny
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_view_wewnetrzny" >
						<option value="" <?php echo !isset($pdf_show_view_wewnetrzny) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_view_wewnetrzny) && strrpos(",".$pdf_show_view_wewnetrzny.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_view_wewnetrzny" value="<?php echo $pdf_show_view_wewnetrzny ?>">
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
					<select name="pob_show_view_wewnetrzny" >
						<option value="" <?php echo !isset($pob_show_view_wewnetrzny) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_view_wewnetrzny) && strrpos(",".$pob_show_view_wewnetrzny.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_view_wewnetrzny" value="<?php echo $pob_show_view_wewnetrzny ?>">
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
			$values = array('show_view_korekta');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_korekta = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_korekta = $res;
			$postValue = $_POST['pdf_show_view_korekta'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_view_korekta != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_view_korekta');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_view_korekta)) {
						$values = array($postValue, 'show_view_korekta');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_view_korekta, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_view_korekta');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_korekta = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_korekta = $res;
			}
			$postValue = $_POST['pob_show_view_korekta'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_view_korekta != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_view_korekta');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_view_korekta)) {
						$values = array($postValue, 'show_view_korekta');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_view_korekta, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_view_korekta');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_korekta = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_korekta = $res;
			}
?>
		<tr>
			<td title="">
					show_view_korekta
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_view_korekta" >
						<option value="" <?php echo !isset($pdf_show_view_korekta) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_view_korekta) && strrpos(",".$pdf_show_view_korekta.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_view_korekta" value="<?php echo $pdf_show_view_korekta ?>">
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
					<select name="pob_show_view_korekta" >
						<option value="" <?php echo !isset($pob_show_view_korekta) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_view_korekta) && strrpos(",".$pob_show_view_korekta.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_view_korekta" value="<?php echo $pob_show_view_korekta ?>">
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
			$values = array('show_view_zastepczy');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_zastepczy = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_zastepczy = $res;
			$postValue = $_POST['pdf_show_view_zastepczy'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_view_zastepczy != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_view_zastepczy');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_view_zastepczy)) {
						$values = array($postValue, 'show_view_zastepczy');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_view_zastepczy, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_view_zastepczy');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_zastepczy = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_zastepczy = $res;
			}
			$postValue = $_POST['pob_show_view_zastepczy'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_view_zastepczy != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_view_zastepczy');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_view_zastepczy)) {
						$values = array($postValue, 'show_view_zastepczy');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_view_zastepczy, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_view_zastepczy');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_zastepczy = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_zastepczy = $res;
			}
?>
		<tr>
			<td title="">
					show_view_zastepczy
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_view_zastepczy" >
						<option value="" <?php echo !isset($pdf_show_view_zastepczy) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_view_zastepczy) && strrpos(",".$pdf_show_view_zastepczy.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_view_zastepczy" value="<?php echo $pdf_show_view_zastepczy ?>">
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
					<select name="pob_show_view_zastepczy" >
						<option value="" <?php echo !isset($pob_show_view_zastepczy) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_view_zastepczy) && strrpos(",".$pob_show_view_zastepczy.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_view_zastepczy" value="<?php echo $pob_show_view_zastepczy ?>">
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
			$values = array('show_view_ostatni_numer');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_ostatni_numer = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_ostatni_numer = $res;
			$postValue = $_POST['pdf_show_view_ostatni_numer'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_view_ostatni_numer != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_view_ostatni_numer');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_view_ostatni_numer)) {
						$values = array($postValue, 'show_view_ostatni_numer');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_view_ostatni_numer, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_view_ostatni_numer');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_ostatni_numer = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_ostatni_numer = $res;
			}
			$postValue = $_POST['pob_show_view_ostatni_numer'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_view_ostatni_numer != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_view_ostatni_numer');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_view_ostatni_numer)) {
						$values = array($postValue, 'show_view_ostatni_numer');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_view_ostatni_numer, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_view_ostatni_numer');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_ostatni_numer = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_ostatni_numer = $res;
			}
?>
		<tr>
			<td title="">
					show_view_ostatni_numer
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_view_ostatni_numer" >
						<option value="" <?php echo !isset($pdf_show_view_ostatni_numer) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_view_ostatni_numer) && strrpos(",".$pdf_show_view_ostatni_numer.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_view_ostatni_numer" value="<?php echo $pdf_show_view_ostatni_numer ?>">
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
					<select name="pob_show_view_ostatni_numer" >
						<option value="" <?php echo !isset($pob_show_view_ostatni_numer) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_view_ostatni_numer) && strrpos(",".$pob_show_view_ostatni_numer.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_view_ostatni_numer" value="<?php echo $pob_show_view_ostatni_numer ?>">
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
			$values = array('show_view_numeracja_rok');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_numeracja_rok = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_numeracja_rok = $res;
			$postValue = $_POST['pdf_show_view_numeracja_rok'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_view_numeracja_rok != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_view_numeracja_rok');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_view_numeracja_rok)) {
						$values = array($postValue, 'show_view_numeracja_rok');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_view_numeracja_rok, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_view_numeracja_rok');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_numeracja_rok = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_numeracja_rok = $res;
			}
			$postValue = $_POST['pob_show_view_numeracja_rok'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_view_numeracja_rok != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_view_numeracja_rok');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_view_numeracja_rok)) {
						$values = array($postValue, 'show_view_numeracja_rok');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_view_numeracja_rok, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_view_numeracja_rok');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_numeracja_rok = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_numeracja_rok = $res;
			}
?>
		<tr>
			<td title="">
					show_view_numeracja_rok
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_view_numeracja_rok" >
						<option value="" <?php echo !isset($pdf_show_view_numeracja_rok) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_view_numeracja_rok) && strrpos(",".$pdf_show_view_numeracja_rok.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_view_numeracja_rok" value="<?php echo $pdf_show_view_numeracja_rok ?>">
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
					<select name="pob_show_view_numeracja_rok" >
						<option value="" <?php echo !isset($pob_show_view_numeracja_rok) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_view_numeracja_rok) && strrpos(",".$pob_show_view_numeracja_rok.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_view_numeracja_rok" value="<?php echo $pob_show_view_numeracja_rok ?>">
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
<?php
			$types = "s";
			$values = array('show_view_grupa_dokumentow');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_grupa_dokumentow = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_grupa_dokumentow = $res;
			$postValue = $_POST['pdf_show_view_grupa_dokumentow'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_view_grupa_dokumentow != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_view_grupa_dokumentow');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_view_grupa_dokumentow)) {
						$values = array($postValue, 'show_view_grupa_dokumentow');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_view_grupa_dokumentow, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_view_grupa_dokumentow');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_grupa_dokumentow = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_grupa_dokumentow = $res;
			}
			$postValue = $_POST['pob_show_view_grupa_dokumentow'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_view_grupa_dokumentow != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_view_grupa_dokumentow');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_view_grupa_dokumentow)) {
						$values = array($postValue, 'show_view_grupa_dokumentow');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_view_grupa_dokumentow, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_view_grupa_dokumentow');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_grupa_dokumentow = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_grupa_dokumentow = $res;
			}
?>
		<tr>
			<td title="">
					show_view_grupa_dokumentow
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_view_grupa_dokumentow" >
						<option value="" <?php echo !isset($pdf_show_view_grupa_dokumentow) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_view_grupa_dokumentow) && strrpos(",".$pdf_show_view_grupa_dokumentow.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_view_grupa_dokumentow" value="<?php echo $pdf_show_view_grupa_dokumentow ?>">
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
					<select name="pob_show_view_grupa_dokumentow" >
						<option value="" <?php echo !isset($pob_show_view_grupa_dokumentow) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_view_grupa_dokumentow) && strrpos(",".$pob_show_view_grupa_dokumentow.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_view_grupa_dokumentow" value="<?php echo $pob_show_view_grupa_dokumentow ?>">
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
<?php
			$options = array();
			$options["0"] = "No";
			$options["1"] = "Yes";
?>
<?php
			$types = "s";
			$values = array('show_view_dokumenty_ksiegowe');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_dokumenty_ksiegowe = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_dokumenty_ksiegowe = $res;
			$postValue = $_POST['pdf_show_view_dokumenty_ksiegowe'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_view_dokumenty_ksiegowe != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_view_dokumenty_ksiegowe');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_view_dokumenty_ksiegowe)) {
						$values = array($postValue, 'show_view_dokumenty_ksiegowe');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_view_dokumenty_ksiegowe, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_view_dokumenty_ksiegowe');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_dokumenty_ksiegowe = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_dokumenty_ksiegowe = $res;
			}
			$postValue = $_POST['pob_show_view_dokumenty_ksiegowe'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_view_dokumenty_ksiegowe != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_view_dokumenty_ksiegowe');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_view_dokumenty_ksiegowe)) {
						$values = array($postValue, 'show_view_dokumenty_ksiegowe');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_view_dokumenty_ksiegowe, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_view_dokumenty_ksiegowe');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_dokumenty_ksiegowe = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_dokumenty_ksiegowe = $res;
			}
?>
		<tr>
			<td title="">
					show_view_dokumenty_ksiegowe
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_view_dokumenty_ksiegowe" >
						<option value="" <?php echo !isset($pdf_show_view_dokumenty_ksiegowe) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_view_dokumenty_ksiegowe) && strrpos(",".$pdf_show_view_dokumenty_ksiegowe.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_view_dokumenty_ksiegowe" value="<?php echo $pdf_show_view_dokumenty_ksiegowe ?>">
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
					<select name="pob_show_view_dokumenty_ksiegowe" >
						<option value="" <?php echo !isset($pob_show_view_dokumenty_ksiegowe) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_view_dokumenty_ksiegowe) && strrpos(",".$pob_show_view_dokumenty_ksiegowe.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_view_dokumenty_ksiegowe" value="<?php echo $pob_show_view_dokumenty_ksiegowe ?>">
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
			$values = array('show_search_nazwa');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_nazwa = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_nazwa = $res;
			$postValue = $_POST['pdf_show_search_nazwa'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_search_nazwa != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_search_nazwa');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_search_nazwa)) {
						$values = array($postValue, 'show_search_nazwa');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_search_nazwa, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_search_nazwa');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_nazwa = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_nazwa = $res;
			}
			$postValue = $_POST['pob_show_search_nazwa'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_search_nazwa != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_search_nazwa');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_search_nazwa)) {
						$values = array($postValue, 'show_search_nazwa');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_search_nazwa, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_search_nazwa');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_nazwa = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_nazwa = $res;
			}
?>
		<tr>
			<td title="">
					show_search_nazwa
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_search_nazwa" >
						<option value="" <?php echo !isset($pdf_show_search_nazwa) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_search_nazwa) && strrpos(",".$pdf_show_search_nazwa.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_search_nazwa" value="<?php echo $pdf_show_search_nazwa ?>">
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
					<select name="pob_show_search_nazwa" >
						<option value="" <?php echo !isset($pob_show_search_nazwa) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_search_nazwa) && strrpos(",".$pob_show_search_nazwa.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_search_nazwa" value="<?php echo $pob_show_search_nazwa ?>">
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
			$values = array('show_search_symbol');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_symbol = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_symbol = $res;
			$postValue = $_POST['pdf_show_search_symbol'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_search_symbol != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_search_symbol');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_search_symbol)) {
						$values = array($postValue, 'show_search_symbol');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_search_symbol, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_search_symbol');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_symbol = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_symbol = $res;
			}
			$postValue = $_POST['pob_show_search_symbol'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_search_symbol != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_search_symbol');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_search_symbol)) {
						$values = array($postValue, 'show_search_symbol');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_search_symbol, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_search_symbol');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_symbol = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_symbol = $res;
			}
?>
		<tr>
			<td title="">
				<strong>
					show_search_symbol
				</strong>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_search_symbol" >
						<option value="" <?php echo !isset($pdf_show_search_symbol) ? "selected " : "" ?>>!!!OBLIGATORY!!!</option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_search_symbol) && strrpos(",".$pdf_show_search_symbol.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_search_symbol" value="<?php echo $pdf_show_search_symbol ?>">
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
					<select name="pob_show_search_symbol" >
						<option value="" <?php echo !isset($pob_show_search_symbol) ? "selected " : "" ?>>!!!OBLIGATORY!!!</option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_search_symbol) && strrpos(",".$pob_show_search_symbol.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_search_symbol" value="<?php echo $pob_show_search_symbol ?>">
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
			$values = array('show_search_zwiekszajacy');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_zwiekszajacy = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_zwiekszajacy = $res;
			$postValue = $_POST['pdf_show_search_zwiekszajacy'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_search_zwiekszajacy != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_search_zwiekszajacy');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_search_zwiekszajacy)) {
						$values = array($postValue, 'show_search_zwiekszajacy');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_search_zwiekszajacy, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_search_zwiekszajacy');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_zwiekszajacy = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_zwiekszajacy = $res;
			}
			$postValue = $_POST['pob_show_search_zwiekszajacy'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_search_zwiekszajacy != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_search_zwiekszajacy');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_search_zwiekszajacy)) {
						$values = array($postValue, 'show_search_zwiekszajacy');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_search_zwiekszajacy, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_search_zwiekszajacy');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_zwiekszajacy = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_zwiekszajacy = $res;
			}
?>
		<tr>
			<td title="">
					show_search_zwiekszajacy
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_search_zwiekszajacy" >
						<option value="" <?php echo !isset($pdf_show_search_zwiekszajacy) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_search_zwiekszajacy) && strrpos(",".$pdf_show_search_zwiekszajacy.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_search_zwiekszajacy" value="<?php echo $pdf_show_search_zwiekszajacy ?>">
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
					<select name="pob_show_search_zwiekszajacy" >
						<option value="" <?php echo !isset($pob_show_search_zwiekszajacy) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_search_zwiekszajacy) && strrpos(",".$pob_show_search_zwiekszajacy.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_search_zwiekszajacy" value="<?php echo $pob_show_search_zwiekszajacy ?>">
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
			$values = array('show_search_wlasny');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_wlasny = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_wlasny = $res;
			$postValue = $_POST['pdf_show_search_wlasny'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_search_wlasny != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_search_wlasny');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_search_wlasny)) {
						$values = array($postValue, 'show_search_wlasny');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_search_wlasny, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_search_wlasny');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_wlasny = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_wlasny = $res;
			}
			$postValue = $_POST['pob_show_search_wlasny'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_search_wlasny != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_search_wlasny');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_search_wlasny)) {
						$values = array($postValue, 'show_search_wlasny');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_search_wlasny, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_search_wlasny');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_wlasny = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_wlasny = $res;
			}
?>
		<tr>
			<td title="">
					show_search_wlasny
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_search_wlasny" >
						<option value="" <?php echo !isset($pdf_show_search_wlasny) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_search_wlasny) && strrpos(",".$pdf_show_search_wlasny.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_search_wlasny" value="<?php echo $pdf_show_search_wlasny ?>">
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
					<select name="pob_show_search_wlasny" >
						<option value="" <?php echo !isset($pob_show_search_wlasny) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_search_wlasny) && strrpos(",".$pob_show_search_wlasny.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_search_wlasny" value="<?php echo $pob_show_search_wlasny ?>">
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
			$values = array('show_search_wewnetrzny');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_wewnetrzny = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_wewnetrzny = $res;
			$postValue = $_POST['pdf_show_search_wewnetrzny'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_search_wewnetrzny != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_search_wewnetrzny');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_search_wewnetrzny)) {
						$values = array($postValue, 'show_search_wewnetrzny');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_search_wewnetrzny, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_search_wewnetrzny');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_wewnetrzny = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_wewnetrzny = $res;
			}
			$postValue = $_POST['pob_show_search_wewnetrzny'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_search_wewnetrzny != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_search_wewnetrzny');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_search_wewnetrzny)) {
						$values = array($postValue, 'show_search_wewnetrzny');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_search_wewnetrzny, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_search_wewnetrzny');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_wewnetrzny = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_wewnetrzny = $res;
			}
?>
		<tr>
			<td title="">
					show_search_wewnetrzny
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_search_wewnetrzny" >
						<option value="" <?php echo !isset($pdf_show_search_wewnetrzny) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_search_wewnetrzny) && strrpos(",".$pdf_show_search_wewnetrzny.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_search_wewnetrzny" value="<?php echo $pdf_show_search_wewnetrzny ?>">
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
					<select name="pob_show_search_wewnetrzny" >
						<option value="" <?php echo !isset($pob_show_search_wewnetrzny) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_search_wewnetrzny) && strrpos(",".$pob_show_search_wewnetrzny.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_search_wewnetrzny" value="<?php echo $pob_show_search_wewnetrzny ?>">
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
			$values = array('show_search_korekta');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_korekta = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_korekta = $res;
			$postValue = $_POST['pdf_show_search_korekta'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_search_korekta != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_search_korekta');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_search_korekta)) {
						$values = array($postValue, 'show_search_korekta');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_search_korekta, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_search_korekta');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_korekta = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_korekta = $res;
			}
			$postValue = $_POST['pob_show_search_korekta'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_search_korekta != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_search_korekta');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_search_korekta)) {
						$values = array($postValue, 'show_search_korekta');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_search_korekta, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_search_korekta');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_korekta = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_korekta = $res;
			}
?>
		<tr>
			<td title="">
					show_search_korekta
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_search_korekta" >
						<option value="" <?php echo !isset($pdf_show_search_korekta) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_search_korekta) && strrpos(",".$pdf_show_search_korekta.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_search_korekta" value="<?php echo $pdf_show_search_korekta ?>">
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
					<select name="pob_show_search_korekta" >
						<option value="" <?php echo !isset($pob_show_search_korekta) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_search_korekta) && strrpos(",".$pob_show_search_korekta.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_search_korekta" value="<?php echo $pob_show_search_korekta ?>">
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
			$values = array('show_search_zastepczy');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_zastepczy = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_zastepczy = $res;
			$postValue = $_POST['pdf_show_search_zastepczy'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_search_zastepczy != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_search_zastepczy');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_search_zastepczy)) {
						$values = array($postValue, 'show_search_zastepczy');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_search_zastepczy, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_search_zastepczy');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_zastepczy = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_zastepczy = $res;
			}
			$postValue = $_POST['pob_show_search_zastepczy'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_search_zastepczy != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_search_zastepczy');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_search_zastepczy)) {
						$values = array($postValue, 'show_search_zastepczy');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_search_zastepczy, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_search_zastepczy');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_zastepczy = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_zastepczy = $res;
			}
?>
		<tr>
			<td title="">
					show_search_zastepczy
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_search_zastepczy" >
						<option value="" <?php echo !isset($pdf_show_search_zastepczy) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_search_zastepczy) && strrpos(",".$pdf_show_search_zastepczy.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_search_zastepczy" value="<?php echo $pdf_show_search_zastepczy ?>">
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
					<select name="pob_show_search_zastepczy" >
						<option value="" <?php echo !isset($pob_show_search_zastepczy) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_search_zastepczy) && strrpos(",".$pob_show_search_zastepczy.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_search_zastepczy" value="<?php echo $pob_show_search_zastepczy ?>">
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
			$values = array('show_search_ostatni_numer');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_ostatni_numer = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_ostatni_numer = $res;
			$postValue = $_POST['pdf_show_search_ostatni_numer'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_search_ostatni_numer != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_search_ostatni_numer');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_search_ostatni_numer)) {
						$values = array($postValue, 'show_search_ostatni_numer');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_search_ostatni_numer, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_search_ostatni_numer');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_ostatni_numer = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_ostatni_numer = $res;
			}
			$postValue = $_POST['pob_show_search_ostatni_numer'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_search_ostatni_numer != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_search_ostatni_numer');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_search_ostatni_numer)) {
						$values = array($postValue, 'show_search_ostatni_numer');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_search_ostatni_numer, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_search_ostatni_numer');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_ostatni_numer = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_ostatni_numer = $res;
			}
?>
		<tr>
			<td title="">
					show_search_ostatni_numer
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_search_ostatni_numer" >
						<option value="" <?php echo !isset($pdf_show_search_ostatni_numer) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_search_ostatni_numer) && strrpos(",".$pdf_show_search_ostatni_numer.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_search_ostatni_numer" value="<?php echo $pdf_show_search_ostatni_numer ?>">
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
					<select name="pob_show_search_ostatni_numer" >
						<option value="" <?php echo !isset($pob_show_search_ostatni_numer) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_search_ostatni_numer) && strrpos(",".$pob_show_search_ostatni_numer.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_search_ostatni_numer" value="<?php echo $pob_show_search_ostatni_numer ?>">
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
			$values = array('show_search_numeracja_rok');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_numeracja_rok = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_numeracja_rok = $res;
			$postValue = $_POST['pdf_show_search_numeracja_rok'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_search_numeracja_rok != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_search_numeracja_rok');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_search_numeracja_rok)) {
						$values = array($postValue, 'show_search_numeracja_rok');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_search_numeracja_rok, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_search_numeracja_rok');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_numeracja_rok = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_numeracja_rok = $res;
			}
			$postValue = $_POST['pob_show_search_numeracja_rok'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_search_numeracja_rok != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_search_numeracja_rok');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_search_numeracja_rok)) {
						$values = array($postValue, 'show_search_numeracja_rok');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_search_numeracja_rok, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_search_numeracja_rok');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_numeracja_rok = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_numeracja_rok = $res;
			}
?>
		<tr>
			<td title="">
					show_search_numeracja_rok
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_search_numeracja_rok" >
						<option value="" <?php echo !isset($pdf_show_search_numeracja_rok) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_search_numeracja_rok) && strrpos(",".$pdf_show_search_numeracja_rok.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_search_numeracja_rok" value="<?php echo $pdf_show_search_numeracja_rok ?>">
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
					<select name="pob_show_search_numeracja_rok" >
						<option value="" <?php echo !isset($pob_show_search_numeracja_rok) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_search_numeracja_rok) && strrpos(",".$pob_show_search_numeracja_rok.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_search_numeracja_rok" value="<?php echo $pob_show_search_numeracja_rok ?>">
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
<?php
			$types = "s";
			$values = array('show_search_grupa_dokumentow');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_grupa_dokumentow = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_grupa_dokumentow = $res;
			$postValue = $_POST['pdf_show_search_grupa_dokumentow'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_search_grupa_dokumentow != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_search_grupa_dokumentow');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_search_grupa_dokumentow)) {
						$values = array($postValue, 'show_search_grupa_dokumentow');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_search_grupa_dokumentow, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_search_grupa_dokumentow');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_grupa_dokumentow = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_grupa_dokumentow = $res;
			}
			$postValue = $_POST['pob_show_search_grupa_dokumentow'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_search_grupa_dokumentow != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_search_grupa_dokumentow');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_search_grupa_dokumentow)) {
						$values = array($postValue, 'show_search_grupa_dokumentow');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_search_grupa_dokumentow, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_search_grupa_dokumentow');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_grupa_dokumentow = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_grupa_dokumentow = $res;
			}
?>
		<tr>
			<td title="">
					show_search_grupa_dokumentow
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_search_grupa_dokumentow" >
						<option value="" <?php echo !isset($pdf_show_search_grupa_dokumentow) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_search_grupa_dokumentow) && strrpos(",".$pdf_show_search_grupa_dokumentow.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_search_grupa_dokumentow" value="<?php echo $pdf_show_search_grupa_dokumentow ?>">
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
					<select name="pob_show_search_grupa_dokumentow" >
						<option value="" <?php echo !isset($pob_show_search_grupa_dokumentow) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_search_grupa_dokumentow) && strrpos(",".$pob_show_search_grupa_dokumentow.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_search_grupa_dokumentow" value="<?php echo $pob_show_search_grupa_dokumentow ?>">
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
<?php
			$options = array();
			$options["0"] = "No";
			$options["1"] = "Yes";
?>
<?php
			$types = "s";
			$values = array('show_search_dokumenty_ksiegowe');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_dokumenty_ksiegowe = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_dokumenty_ksiegowe = $res;
			$postValue = $_POST['pdf_show_search_dokumenty_ksiegowe'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_search_dokumenty_ksiegowe != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_search_dokumenty_ksiegowe');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_search_dokumenty_ksiegowe)) {
						$values = array($postValue, 'show_search_dokumenty_ksiegowe');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_search_dokumenty_ksiegowe, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_search_dokumenty_ksiegowe');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_dokumenty_ksiegowe = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_dokumenty_ksiegowe = $res;
			}
			$postValue = $_POST['pob_show_search_dokumenty_ksiegowe'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_search_dokumenty_ksiegowe != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_search_dokumenty_ksiegowe');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_search_dokumenty_ksiegowe)) {
						$values = array($postValue, 'show_search_dokumenty_ksiegowe');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_search_dokumenty_ksiegowe, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_search_dokumenty_ksiegowe');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_dokumenty_ksiegowe = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_dokumenty_ksiegowe = $res;
			}
?>
		<tr>
			<td title="">
					show_search_dokumenty_ksiegowe
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_search_dokumenty_ksiegowe" >
						<option value="" <?php echo !isset($pdf_show_search_dokumenty_ksiegowe) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_search_dokumenty_ksiegowe) && strrpos(",".$pdf_show_search_dokumenty_ksiegowe.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_search_dokumenty_ksiegowe" value="<?php echo $pdf_show_search_dokumenty_ksiegowe ?>">
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
					<select name="pob_show_search_dokumenty_ksiegowe" >
						<option value="" <?php echo !isset($pob_show_search_dokumenty_ksiegowe) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_search_dokumenty_ksiegowe) && strrpos(",".$pob_show_search_dokumenty_ksiegowe.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_search_dokumenty_ksiegowe" value="<?php echo $pob_show_search_dokumenty_ksiegowe ?>">
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
			$values = array('show_pdf_nazwa');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_nazwa = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_nazwa = $res;
			$postValue = $_POST['pdf_show_pdf_nazwa'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_pdf_nazwa != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_pdf_nazwa');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_pdf_nazwa)) {
						$values = array($postValue, 'show_pdf_nazwa');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_pdf_nazwa, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_pdf_nazwa');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_nazwa = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_nazwa = $res;
			}
			$postValue = $_POST['pob_show_pdf_nazwa'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_pdf_nazwa != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_pdf_nazwa');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_pdf_nazwa)) {
						$values = array($postValue, 'show_pdf_nazwa');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_pdf_nazwa, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_pdf_nazwa');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_nazwa = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_nazwa = $res;
			}
?>
		<tr>
			<td title="">
					show_pdf_nazwa
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_pdf_nazwa" >
						<option value="" <?php echo !isset($pdf_show_pdf_nazwa) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_pdf_nazwa) && strrpos(",".$pdf_show_pdf_nazwa.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_pdf_nazwa" value="<?php echo $pdf_show_pdf_nazwa ?>">
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
					<select name="pob_show_pdf_nazwa" >
						<option value="" <?php echo !isset($pob_show_pdf_nazwa) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_pdf_nazwa) && strrpos(",".$pob_show_pdf_nazwa.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_pdf_nazwa" value="<?php echo $pob_show_pdf_nazwa ?>">
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
			$values = array('show_pdf_symbol');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_symbol = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_symbol = $res;
			$postValue = $_POST['pdf_show_pdf_symbol'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_pdf_symbol != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_pdf_symbol');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_pdf_symbol)) {
						$values = array($postValue, 'show_pdf_symbol');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_pdf_symbol, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_pdf_symbol');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_symbol = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_symbol = $res;
			}
			$postValue = $_POST['pob_show_pdf_symbol'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_pdf_symbol != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_pdf_symbol');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_pdf_symbol)) {
						$values = array($postValue, 'show_pdf_symbol');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_pdf_symbol, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_pdf_symbol');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_symbol = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_symbol = $res;
			}
?>
		<tr>
			<td title="">
				<strong>
					show_pdf_symbol
				</strong>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_pdf_symbol" >
						<option value="" <?php echo !isset($pdf_show_pdf_symbol) ? "selected " : "" ?>>!!!OBLIGATORY!!!</option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_pdf_symbol) && strrpos(",".$pdf_show_pdf_symbol.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_pdf_symbol" value="<?php echo $pdf_show_pdf_symbol ?>">
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
					<select name="pob_show_pdf_symbol" >
						<option value="" <?php echo !isset($pob_show_pdf_symbol) ? "selected " : "" ?>>!!!OBLIGATORY!!!</option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_pdf_symbol) && strrpos(",".$pob_show_pdf_symbol.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_pdf_symbol" value="<?php echo $pob_show_pdf_symbol ?>">
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
			$values = array('show_pdf_zwiekszajacy');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_zwiekszajacy = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_zwiekszajacy = $res;
			$postValue = $_POST['pdf_show_pdf_zwiekszajacy'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_pdf_zwiekszajacy != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_pdf_zwiekszajacy');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_pdf_zwiekszajacy)) {
						$values = array($postValue, 'show_pdf_zwiekszajacy');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_pdf_zwiekszajacy, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_pdf_zwiekszajacy');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_zwiekszajacy = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_zwiekszajacy = $res;
			}
			$postValue = $_POST['pob_show_pdf_zwiekszajacy'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_pdf_zwiekszajacy != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_pdf_zwiekszajacy');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_pdf_zwiekszajacy)) {
						$values = array($postValue, 'show_pdf_zwiekszajacy');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_pdf_zwiekszajacy, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_pdf_zwiekszajacy');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_zwiekszajacy = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_zwiekszajacy = $res;
			}
?>
		<tr>
			<td title="">
					show_pdf_zwiekszajacy
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_pdf_zwiekszajacy" >
						<option value="" <?php echo !isset($pdf_show_pdf_zwiekszajacy) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_pdf_zwiekszajacy) && strrpos(",".$pdf_show_pdf_zwiekszajacy.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_pdf_zwiekszajacy" value="<?php echo $pdf_show_pdf_zwiekszajacy ?>">
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
					<select name="pob_show_pdf_zwiekszajacy" >
						<option value="" <?php echo !isset($pob_show_pdf_zwiekszajacy) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_pdf_zwiekszajacy) && strrpos(",".$pob_show_pdf_zwiekszajacy.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_pdf_zwiekszajacy" value="<?php echo $pob_show_pdf_zwiekszajacy ?>">
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
			$values = array('show_pdf_wlasny');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_wlasny = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_wlasny = $res;
			$postValue = $_POST['pdf_show_pdf_wlasny'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_pdf_wlasny != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_pdf_wlasny');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_pdf_wlasny)) {
						$values = array($postValue, 'show_pdf_wlasny');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_pdf_wlasny, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_pdf_wlasny');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_wlasny = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_wlasny = $res;
			}
			$postValue = $_POST['pob_show_pdf_wlasny'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_pdf_wlasny != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_pdf_wlasny');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_pdf_wlasny)) {
						$values = array($postValue, 'show_pdf_wlasny');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_pdf_wlasny, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_pdf_wlasny');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_wlasny = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_wlasny = $res;
			}
?>
		<tr>
			<td title="">
					show_pdf_wlasny
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_pdf_wlasny" >
						<option value="" <?php echo !isset($pdf_show_pdf_wlasny) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_pdf_wlasny) && strrpos(",".$pdf_show_pdf_wlasny.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_pdf_wlasny" value="<?php echo $pdf_show_pdf_wlasny ?>">
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
					<select name="pob_show_pdf_wlasny" >
						<option value="" <?php echo !isset($pob_show_pdf_wlasny) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_pdf_wlasny) && strrpos(",".$pob_show_pdf_wlasny.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_pdf_wlasny" value="<?php echo $pob_show_pdf_wlasny ?>">
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
			$values = array('show_pdf_wewnetrzny');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_wewnetrzny = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_wewnetrzny = $res;
			$postValue = $_POST['pdf_show_pdf_wewnetrzny'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_pdf_wewnetrzny != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_pdf_wewnetrzny');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_pdf_wewnetrzny)) {
						$values = array($postValue, 'show_pdf_wewnetrzny');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_pdf_wewnetrzny, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_pdf_wewnetrzny');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_wewnetrzny = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_wewnetrzny = $res;
			}
			$postValue = $_POST['pob_show_pdf_wewnetrzny'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_pdf_wewnetrzny != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_pdf_wewnetrzny');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_pdf_wewnetrzny)) {
						$values = array($postValue, 'show_pdf_wewnetrzny');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_pdf_wewnetrzny, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_pdf_wewnetrzny');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_wewnetrzny = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_wewnetrzny = $res;
			}
?>
		<tr>
			<td title="">
					show_pdf_wewnetrzny
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_pdf_wewnetrzny" >
						<option value="" <?php echo !isset($pdf_show_pdf_wewnetrzny) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_pdf_wewnetrzny) && strrpos(",".$pdf_show_pdf_wewnetrzny.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_pdf_wewnetrzny" value="<?php echo $pdf_show_pdf_wewnetrzny ?>">
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
					<select name="pob_show_pdf_wewnetrzny" >
						<option value="" <?php echo !isset($pob_show_pdf_wewnetrzny) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_pdf_wewnetrzny) && strrpos(",".$pob_show_pdf_wewnetrzny.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_pdf_wewnetrzny" value="<?php echo $pob_show_pdf_wewnetrzny ?>">
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
			$values = array('show_pdf_korekta');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_korekta = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_korekta = $res;
			$postValue = $_POST['pdf_show_pdf_korekta'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_pdf_korekta != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_pdf_korekta');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_pdf_korekta)) {
						$values = array($postValue, 'show_pdf_korekta');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_pdf_korekta, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_pdf_korekta');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_korekta = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_korekta = $res;
			}
			$postValue = $_POST['pob_show_pdf_korekta'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_pdf_korekta != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_pdf_korekta');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_pdf_korekta)) {
						$values = array($postValue, 'show_pdf_korekta');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_pdf_korekta, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_pdf_korekta');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_korekta = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_korekta = $res;
			}
?>
		<tr>
			<td title="">
					show_pdf_korekta
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_pdf_korekta" >
						<option value="" <?php echo !isset($pdf_show_pdf_korekta) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_pdf_korekta) && strrpos(",".$pdf_show_pdf_korekta.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_pdf_korekta" value="<?php echo $pdf_show_pdf_korekta ?>">
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
					<select name="pob_show_pdf_korekta" >
						<option value="" <?php echo !isset($pob_show_pdf_korekta) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_pdf_korekta) && strrpos(",".$pob_show_pdf_korekta.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_pdf_korekta" value="<?php echo $pob_show_pdf_korekta ?>">
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
			$values = array('show_pdf_zastepczy');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_zastepczy = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_zastepczy = $res;
			$postValue = $_POST['pdf_show_pdf_zastepczy'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_pdf_zastepczy != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_pdf_zastepczy');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_pdf_zastepczy)) {
						$values = array($postValue, 'show_pdf_zastepczy');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_pdf_zastepczy, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_pdf_zastepczy');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_zastepczy = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_zastepczy = $res;
			}
			$postValue = $_POST['pob_show_pdf_zastepczy'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_pdf_zastepczy != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_pdf_zastepczy');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_pdf_zastepczy)) {
						$values = array($postValue, 'show_pdf_zastepczy');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_pdf_zastepczy, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_pdf_zastepczy');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_zastepczy = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_zastepczy = $res;
			}
?>
		<tr>
			<td title="">
					show_pdf_zastepczy
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_pdf_zastepczy" >
						<option value="" <?php echo !isset($pdf_show_pdf_zastepczy) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_pdf_zastepczy) && strrpos(",".$pdf_show_pdf_zastepczy.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_pdf_zastepczy" value="<?php echo $pdf_show_pdf_zastepczy ?>">
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
					<select name="pob_show_pdf_zastepczy" >
						<option value="" <?php echo !isset($pob_show_pdf_zastepczy) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_pdf_zastepczy) && strrpos(",".$pob_show_pdf_zastepczy.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_pdf_zastepczy" value="<?php echo $pob_show_pdf_zastepczy ?>">
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
			$values = array('show_pdf_ostatni_numer');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_ostatni_numer = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_ostatni_numer = $res;
			$postValue = $_POST['pdf_show_pdf_ostatni_numer'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_pdf_ostatni_numer != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_pdf_ostatni_numer');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_pdf_ostatni_numer)) {
						$values = array($postValue, 'show_pdf_ostatni_numer');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_pdf_ostatni_numer, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_pdf_ostatni_numer');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_ostatni_numer = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_ostatni_numer = $res;
			}
			$postValue = $_POST['pob_show_pdf_ostatni_numer'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_pdf_ostatni_numer != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_pdf_ostatni_numer');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_pdf_ostatni_numer)) {
						$values = array($postValue, 'show_pdf_ostatni_numer');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_pdf_ostatni_numer, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_pdf_ostatni_numer');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_ostatni_numer = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_ostatni_numer = $res;
			}
?>
		<tr>
			<td title="">
					show_pdf_ostatni_numer
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_pdf_ostatni_numer" >
						<option value="" <?php echo !isset($pdf_show_pdf_ostatni_numer) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_pdf_ostatni_numer) && strrpos(",".$pdf_show_pdf_ostatni_numer.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_pdf_ostatni_numer" value="<?php echo $pdf_show_pdf_ostatni_numer ?>">
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
					<select name="pob_show_pdf_ostatni_numer" >
						<option value="" <?php echo !isset($pob_show_pdf_ostatni_numer) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_pdf_ostatni_numer) && strrpos(",".$pob_show_pdf_ostatni_numer.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_pdf_ostatni_numer" value="<?php echo $pob_show_pdf_ostatni_numer ?>">
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
			$values = array('show_pdf_numeracja_rok');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_numeracja_rok = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_numeracja_rok = $res;
			$postValue = $_POST['pdf_show_pdf_numeracja_rok'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_pdf_numeracja_rok != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_pdf_numeracja_rok');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_pdf_numeracja_rok)) {
						$values = array($postValue, 'show_pdf_numeracja_rok');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_pdf_numeracja_rok, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_pdf_numeracja_rok');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_numeracja_rok = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_numeracja_rok = $res;
			}
			$postValue = $_POST['pob_show_pdf_numeracja_rok'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_pdf_numeracja_rok != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_pdf_numeracja_rok');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_pdf_numeracja_rok)) {
						$values = array($postValue, 'show_pdf_numeracja_rok');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_pdf_numeracja_rok, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_pdf_numeracja_rok');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_numeracja_rok = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_numeracja_rok = $res;
			}
?>
		<tr>
			<td title="">
					show_pdf_numeracja_rok
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_pdf_numeracja_rok" >
						<option value="" <?php echo !isset($pdf_show_pdf_numeracja_rok) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_pdf_numeracja_rok) && strrpos(",".$pdf_show_pdf_numeracja_rok.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_pdf_numeracja_rok" value="<?php echo $pdf_show_pdf_numeracja_rok ?>">
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
					<select name="pob_show_pdf_numeracja_rok" >
						<option value="" <?php echo !isset($pob_show_pdf_numeracja_rok) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_pdf_numeracja_rok) && strrpos(",".$pob_show_pdf_numeracja_rok.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_pdf_numeracja_rok" value="<?php echo $pob_show_pdf_numeracja_rok ?>">
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
<?php
			$types = "s";
			$values = array('show_pdf_grupa_dokumentow');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_grupa_dokumentow = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_grupa_dokumentow = $res;
			$postValue = $_POST['pdf_show_pdf_grupa_dokumentow'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_pdf_grupa_dokumentow != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_pdf_grupa_dokumentow');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_pdf_grupa_dokumentow)) {
						$values = array($postValue, 'show_pdf_grupa_dokumentow');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_pdf_grupa_dokumentow, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_pdf_grupa_dokumentow');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_grupa_dokumentow = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_grupa_dokumentow = $res;
			}
			$postValue = $_POST['pob_show_pdf_grupa_dokumentow'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_pdf_grupa_dokumentow != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_pdf_grupa_dokumentow');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_pdf_grupa_dokumentow)) {
						$values = array($postValue, 'show_pdf_grupa_dokumentow');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_pdf_grupa_dokumentow, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_pdf_grupa_dokumentow');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_grupa_dokumentow = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_grupa_dokumentow = $res;
			}
?>
		<tr>
			<td title="">
					show_pdf_grupa_dokumentow
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_pdf_grupa_dokumentow" >
						<option value="" <?php echo !isset($pdf_show_pdf_grupa_dokumentow) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_pdf_grupa_dokumentow) && strrpos(",".$pdf_show_pdf_grupa_dokumentow.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_pdf_grupa_dokumentow" value="<?php echo $pdf_show_pdf_grupa_dokumentow ?>">
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
					<select name="pob_show_pdf_grupa_dokumentow" >
						<option value="" <?php echo !isset($pob_show_pdf_grupa_dokumentow) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_pdf_grupa_dokumentow) && strrpos(",".$pob_show_pdf_grupa_dokumentow.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_pdf_grupa_dokumentow" value="<?php echo $pob_show_pdf_grupa_dokumentow ?>">
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
<?php
			$options = array();
			$options["0"] = "No";
			$options["1"] = "Yes";
?>
<?php
			$types = "s";
			$values = array('show_pdf_dokumenty_ksiegowe');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_dokumenty_ksiegowe = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_dokumenty_ksiegowe = $res;
			$postValue = $_POST['pdf_show_pdf_dokumenty_ksiegowe'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_pdf_dokumenty_ksiegowe != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_pdf_dokumenty_ksiegowe');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_pdf_dokumenty_ksiegowe)) {
						$values = array($postValue, 'show_pdf_dokumenty_ksiegowe');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_pdf_dokumenty_ksiegowe, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_pdf_dokumenty_ksiegowe');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_dokumenty_ksiegowe = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_dokumenty_ksiegowe = $res;
			}
			$postValue = $_POST['pob_show_pdf_dokumenty_ksiegowe'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_pdf_dokumenty_ksiegowe != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_pdf_dokumenty_ksiegowe');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_pdf_dokumenty_ksiegowe)) {
						$values = array($postValue, 'show_pdf_dokumenty_ksiegowe');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_pdf_dokumenty_ksiegowe, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_pdf_dokumenty_ksiegowe');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_dokumenty_ksiegowe = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_dokumenty_ksiegowe = $res;
			}
?>
		<tr>
			<td title="">
					show_pdf_dokumenty_ksiegowe
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_pdf_dokumenty_ksiegowe" >
						<option value="" <?php echo !isset($pdf_show_pdf_dokumenty_ksiegowe) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_pdf_dokumenty_ksiegowe) && strrpos(",".$pdf_show_pdf_dokumenty_ksiegowe.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_pdf_dokumenty_ksiegowe" value="<?php echo $pdf_show_pdf_dokumenty_ksiegowe ?>">
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
					<select name="pob_show_pdf_dokumenty_ksiegowe" >
						<option value="" <?php echo !isset($pob_show_pdf_dokumenty_ksiegowe) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_pdf_dokumenty_ksiegowe) && strrpos(",".$pob_show_pdf_dokumenty_ksiegowe.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_pdf_dokumenty_ksiegowe" value="<?php echo $pob_show_pdf_dokumenty_ksiegowe ?>">
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
			$values = array('show_export_nazwa');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_nazwa = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_nazwa = $res;
			$postValue = $_POST['pdf_show_export_nazwa'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_export_nazwa != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_export_nazwa');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_export_nazwa)) {
						$values = array($postValue, 'show_export_nazwa');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_export_nazwa, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_export_nazwa');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_nazwa = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_nazwa = $res;
			}
			$postValue = $_POST['pob_show_export_nazwa'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_export_nazwa != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_export_nazwa');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_export_nazwa)) {
						$values = array($postValue, 'show_export_nazwa');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_export_nazwa, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_export_nazwa');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_nazwa = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_nazwa = $res;
			}
?>
		<tr>
			<td title="">
					show_export_nazwa
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_export_nazwa" >
						<option value="" <?php echo !isset($pdf_show_export_nazwa) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_export_nazwa) && strrpos(",".$pdf_show_export_nazwa.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_export_nazwa" value="<?php echo $pdf_show_export_nazwa ?>">
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
					<select name="pob_show_export_nazwa" >
						<option value="" <?php echo !isset($pob_show_export_nazwa) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_export_nazwa) && strrpos(",".$pob_show_export_nazwa.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_export_nazwa" value="<?php echo $pob_show_export_nazwa ?>">
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
			$values = array('show_export_symbol');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_symbol = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_symbol = $res;
			$postValue = $_POST['pdf_show_export_symbol'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_export_symbol != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_export_symbol');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_export_symbol)) {
						$values = array($postValue, 'show_export_symbol');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_export_symbol, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_export_symbol');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_symbol = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_symbol = $res;
			}
			$postValue = $_POST['pob_show_export_symbol'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_export_symbol != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_export_symbol');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_export_symbol)) {
						$values = array($postValue, 'show_export_symbol');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_export_symbol, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_export_symbol');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_symbol = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_symbol = $res;
			}
?>
		<tr>
			<td title="">
				<strong>
					show_export_symbol
				</strong>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_export_symbol" >
						<option value="" <?php echo !isset($pdf_show_export_symbol) ? "selected " : "" ?>>!!!OBLIGATORY!!!</option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_export_symbol) && strrpos(",".$pdf_show_export_symbol.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_export_symbol" value="<?php echo $pdf_show_export_symbol ?>">
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
					<select name="pob_show_export_symbol" >
						<option value="" <?php echo !isset($pob_show_export_symbol) ? "selected " : "" ?>>!!!OBLIGATORY!!!</option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_export_symbol) && strrpos(",".$pob_show_export_symbol.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_export_symbol" value="<?php echo $pob_show_export_symbol ?>">
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
			$values = array('show_export_zwiekszajacy');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_zwiekszajacy = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_zwiekszajacy = $res;
			$postValue = $_POST['pdf_show_export_zwiekszajacy'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_export_zwiekszajacy != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_export_zwiekszajacy');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_export_zwiekszajacy)) {
						$values = array($postValue, 'show_export_zwiekszajacy');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_export_zwiekszajacy, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_export_zwiekszajacy');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_zwiekszajacy = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_zwiekszajacy = $res;
			}
			$postValue = $_POST['pob_show_export_zwiekszajacy'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_export_zwiekszajacy != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_export_zwiekszajacy');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_export_zwiekszajacy)) {
						$values = array($postValue, 'show_export_zwiekszajacy');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_export_zwiekszajacy, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_export_zwiekszajacy');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_zwiekszajacy = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_zwiekszajacy = $res;
			}
?>
		<tr>
			<td title="">
					show_export_zwiekszajacy
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_export_zwiekszajacy" >
						<option value="" <?php echo !isset($pdf_show_export_zwiekszajacy) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_export_zwiekszajacy) && strrpos(",".$pdf_show_export_zwiekszajacy.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_export_zwiekszajacy" value="<?php echo $pdf_show_export_zwiekszajacy ?>">
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
					<select name="pob_show_export_zwiekszajacy" >
						<option value="" <?php echo !isset($pob_show_export_zwiekszajacy) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_export_zwiekszajacy) && strrpos(",".$pob_show_export_zwiekszajacy.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_export_zwiekszajacy" value="<?php echo $pob_show_export_zwiekszajacy ?>">
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
			$values = array('show_export_wlasny');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_wlasny = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_wlasny = $res;
			$postValue = $_POST['pdf_show_export_wlasny'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_export_wlasny != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_export_wlasny');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_export_wlasny)) {
						$values = array($postValue, 'show_export_wlasny');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_export_wlasny, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_export_wlasny');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_wlasny = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_wlasny = $res;
			}
			$postValue = $_POST['pob_show_export_wlasny'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_export_wlasny != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_export_wlasny');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_export_wlasny)) {
						$values = array($postValue, 'show_export_wlasny');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_export_wlasny, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_export_wlasny');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_wlasny = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_wlasny = $res;
			}
?>
		<tr>
			<td title="">
					show_export_wlasny
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_export_wlasny" >
						<option value="" <?php echo !isset($pdf_show_export_wlasny) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_export_wlasny) && strrpos(",".$pdf_show_export_wlasny.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_export_wlasny" value="<?php echo $pdf_show_export_wlasny ?>">
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
					<select name="pob_show_export_wlasny" >
						<option value="" <?php echo !isset($pob_show_export_wlasny) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_export_wlasny) && strrpos(",".$pob_show_export_wlasny.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_export_wlasny" value="<?php echo $pob_show_export_wlasny ?>">
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
			$values = array('show_export_wewnetrzny');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_wewnetrzny = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_wewnetrzny = $res;
			$postValue = $_POST['pdf_show_export_wewnetrzny'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_export_wewnetrzny != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_export_wewnetrzny');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_export_wewnetrzny)) {
						$values = array($postValue, 'show_export_wewnetrzny');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_export_wewnetrzny, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_export_wewnetrzny');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_wewnetrzny = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_wewnetrzny = $res;
			}
			$postValue = $_POST['pob_show_export_wewnetrzny'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_export_wewnetrzny != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_export_wewnetrzny');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_export_wewnetrzny)) {
						$values = array($postValue, 'show_export_wewnetrzny');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_export_wewnetrzny, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_export_wewnetrzny');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_wewnetrzny = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_wewnetrzny = $res;
			}
?>
		<tr>
			<td title="">
					show_export_wewnetrzny
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_export_wewnetrzny" >
						<option value="" <?php echo !isset($pdf_show_export_wewnetrzny) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_export_wewnetrzny) && strrpos(",".$pdf_show_export_wewnetrzny.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_export_wewnetrzny" value="<?php echo $pdf_show_export_wewnetrzny ?>">
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
					<select name="pob_show_export_wewnetrzny" >
						<option value="" <?php echo !isset($pob_show_export_wewnetrzny) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_export_wewnetrzny) && strrpos(",".$pob_show_export_wewnetrzny.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_export_wewnetrzny" value="<?php echo $pob_show_export_wewnetrzny ?>">
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
			$values = array('show_export_korekta');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_korekta = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_korekta = $res;
			$postValue = $_POST['pdf_show_export_korekta'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_export_korekta != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_export_korekta');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_export_korekta)) {
						$values = array($postValue, 'show_export_korekta');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_export_korekta, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_export_korekta');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_korekta = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_korekta = $res;
			}
			$postValue = $_POST['pob_show_export_korekta'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_export_korekta != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_export_korekta');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_export_korekta)) {
						$values = array($postValue, 'show_export_korekta');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_export_korekta, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_export_korekta');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_korekta = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_korekta = $res;
			}
?>
		<tr>
			<td title="">
					show_export_korekta
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_export_korekta" >
						<option value="" <?php echo !isset($pdf_show_export_korekta) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_export_korekta) && strrpos(",".$pdf_show_export_korekta.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_export_korekta" value="<?php echo $pdf_show_export_korekta ?>">
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
					<select name="pob_show_export_korekta" >
						<option value="" <?php echo !isset($pob_show_export_korekta) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_export_korekta) && strrpos(",".$pob_show_export_korekta.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_export_korekta" value="<?php echo $pob_show_export_korekta ?>">
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
			$values = array('show_export_zastepczy');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_zastepczy = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_zastepczy = $res;
			$postValue = $_POST['pdf_show_export_zastepczy'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_export_zastepczy != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_export_zastepczy');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_export_zastepczy)) {
						$values = array($postValue, 'show_export_zastepczy');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_export_zastepczy, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_export_zastepczy');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_zastepczy = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_zastepczy = $res;
			}
			$postValue = $_POST['pob_show_export_zastepczy'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_export_zastepczy != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_export_zastepczy');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_export_zastepczy)) {
						$values = array($postValue, 'show_export_zastepczy');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_export_zastepczy, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_export_zastepczy');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_zastepczy = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_zastepczy = $res;
			}
?>
		<tr>
			<td title="">
					show_export_zastepczy
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_export_zastepczy" >
						<option value="" <?php echo !isset($pdf_show_export_zastepczy) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_export_zastepczy) && strrpos(",".$pdf_show_export_zastepczy.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_export_zastepczy" value="<?php echo $pdf_show_export_zastepczy ?>">
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
					<select name="pob_show_export_zastepczy" >
						<option value="" <?php echo !isset($pob_show_export_zastepczy) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_export_zastepczy) && strrpos(",".$pob_show_export_zastepczy.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_export_zastepczy" value="<?php echo $pob_show_export_zastepczy ?>">
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
			$values = array('show_export_ostatni_numer');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_ostatni_numer = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_ostatni_numer = $res;
			$postValue = $_POST['pdf_show_export_ostatni_numer'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_export_ostatni_numer != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_export_ostatni_numer');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_export_ostatni_numer)) {
						$values = array($postValue, 'show_export_ostatni_numer');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_export_ostatni_numer, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_export_ostatni_numer');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_ostatni_numer = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_ostatni_numer = $res;
			}
			$postValue = $_POST['pob_show_export_ostatni_numer'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_export_ostatni_numer != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_export_ostatni_numer');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_export_ostatni_numer)) {
						$values = array($postValue, 'show_export_ostatni_numer');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_export_ostatni_numer, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_export_ostatni_numer');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_ostatni_numer = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_ostatni_numer = $res;
			}
?>
		<tr>
			<td title="">
					show_export_ostatni_numer
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_export_ostatni_numer" >
						<option value="" <?php echo !isset($pdf_show_export_ostatni_numer) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_export_ostatni_numer) && strrpos(",".$pdf_show_export_ostatni_numer.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_export_ostatni_numer" value="<?php echo $pdf_show_export_ostatni_numer ?>">
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
					<select name="pob_show_export_ostatni_numer" >
						<option value="" <?php echo !isset($pob_show_export_ostatni_numer) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_export_ostatni_numer) && strrpos(",".$pob_show_export_ostatni_numer.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_export_ostatni_numer" value="<?php echo $pob_show_export_ostatni_numer ?>">
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
			$values = array('show_export_numeracja_rok');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_numeracja_rok = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_numeracja_rok = $res;
			$postValue = $_POST['pdf_show_export_numeracja_rok'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_export_numeracja_rok != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_export_numeracja_rok');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_export_numeracja_rok)) {
						$values = array($postValue, 'show_export_numeracja_rok');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_export_numeracja_rok, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_export_numeracja_rok');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_numeracja_rok = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_numeracja_rok = $res;
			}
			$postValue = $_POST['pob_show_export_numeracja_rok'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_export_numeracja_rok != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_export_numeracja_rok');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_export_numeracja_rok)) {
						$values = array($postValue, 'show_export_numeracja_rok');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_export_numeracja_rok, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_export_numeracja_rok');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_numeracja_rok = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_numeracja_rok = $res;
			}
?>
		<tr>
			<td title="">
					show_export_numeracja_rok
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_export_numeracja_rok" >
						<option value="" <?php echo !isset($pdf_show_export_numeracja_rok) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_export_numeracja_rok) && strrpos(",".$pdf_show_export_numeracja_rok.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_export_numeracja_rok" value="<?php echo $pdf_show_export_numeracja_rok ?>">
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
					<select name="pob_show_export_numeracja_rok" >
						<option value="" <?php echo !isset($pob_show_export_numeracja_rok) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_export_numeracja_rok) && strrpos(",".$pob_show_export_numeracja_rok.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_export_numeracja_rok" value="<?php echo $pob_show_export_numeracja_rok ?>">
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
<?php
			$types = "s";
			$values = array('show_export_grupa_dokumentow');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_grupa_dokumentow = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_grupa_dokumentow = $res;
			$postValue = $_POST['pdf_show_export_grupa_dokumentow'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_export_grupa_dokumentow != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_export_grupa_dokumentow');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_export_grupa_dokumentow)) {
						$values = array($postValue, 'show_export_grupa_dokumentow');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_export_grupa_dokumentow, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_export_grupa_dokumentow');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_grupa_dokumentow = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_grupa_dokumentow = $res;
			}
			$postValue = $_POST['pob_show_export_grupa_dokumentow'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_export_grupa_dokumentow != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_export_grupa_dokumentow');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_export_grupa_dokumentow)) {
						$values = array($postValue, 'show_export_grupa_dokumentow');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_export_grupa_dokumentow, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_export_grupa_dokumentow');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_grupa_dokumentow = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_grupa_dokumentow = $res;
			}
?>
		<tr>
			<td title="">
					show_export_grupa_dokumentow
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_export_grupa_dokumentow" >
						<option value="" <?php echo !isset($pdf_show_export_grupa_dokumentow) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_export_grupa_dokumentow) && strrpos(",".$pdf_show_export_grupa_dokumentow.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_export_grupa_dokumentow" value="<?php echo $pdf_show_export_grupa_dokumentow ?>">
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
					<select name="pob_show_export_grupa_dokumentow" >
						<option value="" <?php echo !isset($pob_show_export_grupa_dokumentow) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_export_grupa_dokumentow) && strrpos(",".$pob_show_export_grupa_dokumentow.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_export_grupa_dokumentow" value="<?php echo $pob_show_export_grupa_dokumentow ?>">
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
<?php
			$options = array();
			$options["0"] = "No";
			$options["1"] = "Yes";
?>
<?php
			$types = "s";
			$values = array('show_export_dokumenty_ksiegowe');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_dokumenty_ksiegowe = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_dokumenty_ksiegowe = $res;
			$postValue = $_POST['pdf_show_export_dokumenty_ksiegowe'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_export_dokumenty_ksiegowe != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_export_dokumenty_ksiegowe');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_export_dokumenty_ksiegowe)) {
						$values = array($postValue, 'show_export_dokumenty_ksiegowe');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_export_dokumenty_ksiegowe, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_export_dokumenty_ksiegowe');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_dokumenty_ksiegowe = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_dokumenty_ksiegowe = $res;
			}
			$postValue = $_POST['pob_show_export_dokumenty_ksiegowe'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_export_dokumenty_ksiegowe != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('show_export_dokumenty_ksiegowe');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_export_dokumenty_ksiegowe)) {
						$values = array($postValue, 'show_export_dokumenty_ksiegowe');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_export_dokumenty_ksiegowe, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_export_dokumenty_ksiegowe');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_dokumenty_ksiegowe = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_dokumenty_ksiegowe = $res;
			}
?>
		<tr>
			<td title="">
					show_export_dokumenty_ksiegowe
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_export_dokumenty_ksiegowe" >
						<option value="" <?php echo !isset($pdf_show_export_dokumenty_ksiegowe) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_export_dokumenty_ksiegowe) && strrpos(",".$pdf_show_export_dokumenty_ksiegowe.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_export_dokumenty_ksiegowe" value="<?php echo $pdf_show_export_dokumenty_ksiegowe ?>">
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
					<select name="pob_show_export_dokumenty_ksiegowe" >
						<option value="" <?php echo !isset($pob_show_export_dokumenty_ksiegowe) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_export_dokumenty_ksiegowe) && strrpos(",".$pob_show_export_dokumenty_ksiegowe.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_export_dokumenty_ksiegowe" value="<?php echo $pob_show_export_dokumenty_ksiegowe ?>">
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
  gdk_id,
  gdk_virgo_title
FROM 
  slk_grupy_dokumentow
SQL;
			$result = $databaseHandler->query($query);
			while ($row = mysqli_fetch_row($result)) {
				$options[$row[0]] = "{$row[1]}";
			}
			mysqli_free_result($result);			
?>
<?php
			$types = "s";
			$values = array('limit_to_grupa_dokumentow');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_limit_to_grupa_dokumentow = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_limit_to_grupa_dokumentow = $res;
			$postValue = $_POST['pdf_limit_to_grupa_dokumentow'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_limit_to_grupa_dokumentow != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('limit_to_grupa_dokumentow');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_limit_to_grupa_dokumentow)) {
						$values = array($postValue, 'limit_to_grupa_dokumentow');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(limit_to_grupa_dokumentow, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('limit_to_grupa_dokumentow');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_limit_to_grupa_dokumentow = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_limit_to_grupa_dokumentow = $res;
			}
			$postValue = $_POST['pob_limit_to_grupa_dokumentow'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_limit_to_grupa_dokumentow != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('limit_to_grupa_dokumentow');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_limit_to_grupa_dokumentow)) {
						$values = array($postValue, 'limit_to_grupa_dokumentow');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(limit_to_grupa_dokumentow, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('limit_to_grupa_dokumentow');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_limit_to_grupa_dokumentow = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_limit_to_grupa_dokumentow = $res;
			}
?>
		<tr>
			<td title="">
					limit_to_grupa_dokumentow
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_limit_to_grupa_dokumentow[]" multiple='multiple'>
						<option value="" <?php echo !isset($pdf_limit_to_grupa_dokumentow) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_limit_to_grupa_dokumentow) && strrpos(",".$pdf_limit_to_grupa_dokumentow.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_limit_to_grupa_dokumentow" value="<?php echo $pdf_limit_to_grupa_dokumentow ?>">
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
					<select name="pob_limit_to_grupa_dokumentow[]" multiple='multiple'>
						<option value="" <?php echo !isset($pob_limit_to_grupa_dokumentow) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_limit_to_grupa_dokumentow) && strrpos(",".$pob_limit_to_grupa_dokumentow.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_limit_to_grupa_dokumentow" value="<?php echo $pob_limit_to_grupa_dokumentow ?>">
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
					$values = array('custom_sql_condition');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_custom_sql_condition)) {
						$values = array($postValue, 'custom_sql_condition');
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
					$values = array('custom_sql_condition');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_custom_sql_condition)) {
						$values = array($postValue, 'custom_sql_condition');
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
			<td title="Custom SQL condition (eg. rdk_abc_id in (select abc_id from...)) You can use classes $currentUser and $currentPage (eg. rdk_usr_created_id = {$user->getId()})">custom_sql_condition</td>
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
					$values = array('custom_parent_query');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_custom_parent_query)) {
						$values = array($postValue, 'custom_parent_query');
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
					$values = array('custom_parent_query');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_custom_parent_query)) {
						$values = array($postValue, 'custom_parent_query');
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
					$values = array('import_mode');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_import_mode)) {
						$values = array($postValue, 'import_mode');
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
					$values = array('import_mode');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_import_mode)) {
						$values = array($postValue, 'import_mode');
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
					$values = array('field_separator');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_field_separator)) {
						$values = array($postValue, 'field_separator');
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
					$values = array('field_separator');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_field_separator)) {
						$values = array($postValue, 'field_separator');
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
			$options = array();
			$options[-1] = "record created by logged in user";
			$query = <<<SQL
SELECT 
  gdk_id,
  gdk_virgo_title
FROM 
  slk_grupy_dokumentow
SQL;
			$result = $databaseHandler->query($query);
			while ($row = mysqli_fetch_row($result)) {
				$options[$row[0]] = "{$row[1]}";
			}
			mysqli_free_result($result);			
?>
<?php
			$types = "s";
			$values = array('import_default_value_grupa_dokumentow');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_import_default_value_grupa_dokumentow = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_import_default_value_grupa_dokumentow = $res;
			$postValue = $_POST['pdf_import_default_value_grupa_dokumentow'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_import_default_value_grupa_dokumentow != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('import_default_value_grupa_dokumentow');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_import_default_value_grupa_dokumentow)) {
						$values = array($postValue, 'import_default_value_grupa_dokumentow');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(import_default_value_grupa_dokumentow, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('import_default_value_grupa_dokumentow');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_import_default_value_grupa_dokumentow = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_import_default_value_grupa_dokumentow = $res;
			}
			$postValue = $_POST['pob_import_default_value_grupa_dokumentow'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_import_default_value_grupa_dokumentow != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array('import_default_value_grupa_dokumentow');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_import_default_value_grupa_dokumentow)) {
						$values = array($postValue, 'import_default_value_grupa_dokumentow');
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(import_default_value_grupa_dokumentow, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('import_default_value_grupa_dokumentow');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_import_default_value_grupa_dokumentow = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_import_default_value_grupa_dokumentow = $res;
			}
?>
		<tr>
			<td title="">
					import_default_value_grupa_dokumentow
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_import_default_value_grupa_dokumentow" >
						<option value="" <?php echo !isset($pdf_import_default_value_grupa_dokumentow) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_import_default_value_grupa_dokumentow) && strrpos(",".$pdf_import_default_value_grupa_dokumentow.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_import_default_value_grupa_dokumentow" value="<?php echo $pdf_import_default_value_grupa_dokumentow ?>">
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
					<select name="pob_import_default_value_grupa_dokumentow" >
						<option value="" <?php echo !isset($pob_import_default_value_grupa_dokumentow) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_import_default_value_grupa_dokumentow) && strrpos(",".$pob_import_default_value_grupa_dokumentow.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_import_default_value_grupa_dokumentow" value="<?php echo $pob_import_default_value_grupa_dokumentow ?>">
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
	if (isset($_POST['HINT_rodzaj_dokumentu'])) {
		$newHint = $_POST['HINT_rodzaj_dokumentu'];
		$newHint = trim($newHint);
		if ($newHint == "") {
			$newHint = null;
		}
		$query = "";
		if (isset($newHint)) {
	$hintId = null;
	$hintText = null;
	$query = " SELECT trn_id, trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_rodzaj_dokumentu'));
	foreach ($result as $res) {
		$hintId = $row[trn_id];
		$hintText = $row[trn_text];
	}
			if (isset($hintId)) {
				if ($newHint != $hintText) {
					$query = " UPDATE prt_translations SET trn_text = '" . $newHint . "' WHERE trn_id = " . $hintId;
				}
			} else {
					$query = " INSERT INTO prt_translations (trn_lng_id, trn_token, trn_text) VALUES (" . $lngId . ", 'HINT_rodzaj_dokumentu', '" . $newHint . "')";
			}
		} else {
	$hintId = null;
	$hintText = null;
	$query = " SELECT trn_id, trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_rodzaj_dokumentu'));
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
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_rodzaj_dokumentu'));
	$text = null;
	foreach ($result as $row) {
		$text = $row[trn_text];
	}
?>
	<tr>
		<td>HINT_rodzaj_dokumentu</td>
		<td colspan="2"><textarea cols="60" rows="4" name="HINT_rodzaj_dokumentu"><?php echo $text ?></textarea></td>
		<td>
			<input type="submit" value="Store"/>
		</td>			
	</tr>
<?php 
	if (isset($_POST['HINT_rodzaj_dokumentu_nazwa'])) {
		$newHint = $_POST['HINT_rodzaj_dokumentu_nazwa'];
		$newHint = trim($newHint);
		if ($newHint == "") {
			$newHint = null;
		}
		$query = "";
		if (isset($newHint)) {
	$hintId = null;
	$hintText = null;
	$query = " SELECT trn_id, trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_rodzaj_dokumentu_nazwa'));
	foreach ($result as $res) {
		$hintId = $row[trn_id];
		$hintText = $row[trn_text];
	}
			if (isset($hintId)) {
				if ($newHint != $hintText) {
					$query = " UPDATE prt_translations SET trn_text = '" . $newHint . "' WHERE trn_id = " . $hintId;
				}
			} else {
					$query = " INSERT INTO prt_translations (trn_lng_id, trn_token, trn_text) VALUES (" . $lngId . ", 'HINT_rodzaj_dokumentu_nazwa', '" . $newHint . "')";
			}
		} else {
	$hintId = null;
	$hintText = null;
	$query = " SELECT trn_id, trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_rodzaj_dokumentu_nazwa'));
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
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_rodzaj_dokumentu_nazwa'));
	$text = null;
	foreach ($result as $row) {
		$text = $row[trn_text];
	}
?>
	<tr>
		<td>HINT_rodzaj_dokumentu_nazwa</td>
		<td colspan="2"><textarea cols="60" rows="4" name="HINT_rodzaj_dokumentu_nazwa"><?php echo $text ?></textarea></td>
		<td>
			<input type="submit" value="Store"/>
		</td>			
	</tr>
<?php 
	if (isset($_POST['HINT_rodzaj_dokumentu_symbol'])) {
		$newHint = $_POST['HINT_rodzaj_dokumentu_symbol'];
		$newHint = trim($newHint);
		if ($newHint == "") {
			$newHint = null;
		}
		$query = "";
		if (isset($newHint)) {
	$hintId = null;
	$hintText = null;
	$query = " SELECT trn_id, trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_rodzaj_dokumentu_symbol'));
	foreach ($result as $res) {
		$hintId = $row[trn_id];
		$hintText = $row[trn_text];
	}
			if (isset($hintId)) {
				if ($newHint != $hintText) {
					$query = " UPDATE prt_translations SET trn_text = '" . $newHint . "' WHERE trn_id = " . $hintId;
				}
			} else {
					$query = " INSERT INTO prt_translations (trn_lng_id, trn_token, trn_text) VALUES (" . $lngId . ", 'HINT_rodzaj_dokumentu_symbol', '" . $newHint . "')";
			}
		} else {
	$hintId = null;
	$hintText = null;
	$query = " SELECT trn_id, trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_rodzaj_dokumentu_symbol'));
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
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_rodzaj_dokumentu_symbol'));
	$text = null;
	foreach ($result as $row) {
		$text = $row[trn_text];
	}
?>
	<tr>
		<td>HINT_rodzaj_dokumentu_symbol</td>
		<td colspan="2"><textarea cols="60" rows="4" name="HINT_rodzaj_dokumentu_symbol"><?php echo $text ?></textarea></td>
		<td>
			<input type="submit" value="Store"/>
		</td>			
	</tr>
<?php 
	if (isset($_POST['HINT_rodzaj_dokumentu_zwiekszajacy'])) {
		$newHint = $_POST['HINT_rodzaj_dokumentu_zwiekszajacy'];
		$newHint = trim($newHint);
		if ($newHint == "") {
			$newHint = null;
		}
		$query = "";
		if (isset($newHint)) {
	$hintId = null;
	$hintText = null;
	$query = " SELECT trn_id, trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_rodzaj_dokumentu_zwiekszajacy'));
	foreach ($result as $res) {
		$hintId = $row[trn_id];
		$hintText = $row[trn_text];
	}
			if (isset($hintId)) {
				if ($newHint != $hintText) {
					$query = " UPDATE prt_translations SET trn_text = '" . $newHint . "' WHERE trn_id = " . $hintId;
				}
			} else {
					$query = " INSERT INTO prt_translations (trn_lng_id, trn_token, trn_text) VALUES (" . $lngId . ", 'HINT_rodzaj_dokumentu_zwiekszajacy', '" . $newHint . "')";
			}
		} else {
	$hintId = null;
	$hintText = null;
	$query = " SELECT trn_id, trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_rodzaj_dokumentu_zwiekszajacy'));
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
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_rodzaj_dokumentu_zwiekszajacy'));
	$text = null;
	foreach ($result as $row) {
		$text = $row[trn_text];
	}
?>
	<tr>
		<td>HINT_rodzaj_dokumentu_zwiekszajacy</td>
		<td colspan="2"><textarea cols="60" rows="4" name="HINT_rodzaj_dokumentu_zwiekszajacy"><?php echo $text ?></textarea></td>
		<td>
			<input type="submit" value="Store"/>
		</td>			
	</tr>
<?php 
	if (isset($_POST['HINT_rodzaj_dokumentu_wlasny'])) {
		$newHint = $_POST['HINT_rodzaj_dokumentu_wlasny'];
		$newHint = trim($newHint);
		if ($newHint == "") {
			$newHint = null;
		}
		$query = "";
		if (isset($newHint)) {
	$hintId = null;
	$hintText = null;
	$query = " SELECT trn_id, trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_rodzaj_dokumentu_wlasny'));
	foreach ($result as $res) {
		$hintId = $row[trn_id];
		$hintText = $row[trn_text];
	}
			if (isset($hintId)) {
				if ($newHint != $hintText) {
					$query = " UPDATE prt_translations SET trn_text = '" . $newHint . "' WHERE trn_id = " . $hintId;
				}
			} else {
					$query = " INSERT INTO prt_translations (trn_lng_id, trn_token, trn_text) VALUES (" . $lngId . ", 'HINT_rodzaj_dokumentu_wlasny', '" . $newHint . "')";
			}
		} else {
	$hintId = null;
	$hintText = null;
	$query = " SELECT trn_id, trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_rodzaj_dokumentu_wlasny'));
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
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_rodzaj_dokumentu_wlasny'));
	$text = null;
	foreach ($result as $row) {
		$text = $row[trn_text];
	}
?>
	<tr>
		<td>HINT_rodzaj_dokumentu_wlasny</td>
		<td colspan="2"><textarea cols="60" rows="4" name="HINT_rodzaj_dokumentu_wlasny"><?php echo $text ?></textarea></td>
		<td>
			<input type="submit" value="Store"/>
		</td>			
	</tr>
<?php 
	if (isset($_POST['HINT_rodzaj_dokumentu_wewnetrzny'])) {
		$newHint = $_POST['HINT_rodzaj_dokumentu_wewnetrzny'];
		$newHint = trim($newHint);
		if ($newHint == "") {
			$newHint = null;
		}
		$query = "";
		if (isset($newHint)) {
	$hintId = null;
	$hintText = null;
	$query = " SELECT trn_id, trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_rodzaj_dokumentu_wewnetrzny'));
	foreach ($result as $res) {
		$hintId = $row[trn_id];
		$hintText = $row[trn_text];
	}
			if (isset($hintId)) {
				if ($newHint != $hintText) {
					$query = " UPDATE prt_translations SET trn_text = '" . $newHint . "' WHERE trn_id = " . $hintId;
				}
			} else {
					$query = " INSERT INTO prt_translations (trn_lng_id, trn_token, trn_text) VALUES (" . $lngId . ", 'HINT_rodzaj_dokumentu_wewnetrzny', '" . $newHint . "')";
			}
		} else {
	$hintId = null;
	$hintText = null;
	$query = " SELECT trn_id, trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_rodzaj_dokumentu_wewnetrzny'));
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
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_rodzaj_dokumentu_wewnetrzny'));
	$text = null;
	foreach ($result as $row) {
		$text = $row[trn_text];
	}
?>
	<tr>
		<td>HINT_rodzaj_dokumentu_wewnetrzny</td>
		<td colspan="2"><textarea cols="60" rows="4" name="HINT_rodzaj_dokumentu_wewnetrzny"><?php echo $text ?></textarea></td>
		<td>
			<input type="submit" value="Store"/>
		</td>			
	</tr>
<?php 
	if (isset($_POST['HINT_rodzaj_dokumentu_korekta'])) {
		$newHint = $_POST['HINT_rodzaj_dokumentu_korekta'];
		$newHint = trim($newHint);
		if ($newHint == "") {
			$newHint = null;
		}
		$query = "";
		if (isset($newHint)) {
	$hintId = null;
	$hintText = null;
	$query = " SELECT trn_id, trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_rodzaj_dokumentu_korekta'));
	foreach ($result as $res) {
		$hintId = $row[trn_id];
		$hintText = $row[trn_text];
	}
			if (isset($hintId)) {
				if ($newHint != $hintText) {
					$query = " UPDATE prt_translations SET trn_text = '" . $newHint . "' WHERE trn_id = " . $hintId;
				}
			} else {
					$query = " INSERT INTO prt_translations (trn_lng_id, trn_token, trn_text) VALUES (" . $lngId . ", 'HINT_rodzaj_dokumentu_korekta', '" . $newHint . "')";
			}
		} else {
	$hintId = null;
	$hintText = null;
	$query = " SELECT trn_id, trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_rodzaj_dokumentu_korekta'));
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
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_rodzaj_dokumentu_korekta'));
	$text = null;
	foreach ($result as $row) {
		$text = $row[trn_text];
	}
?>
	<tr>
		<td>HINT_rodzaj_dokumentu_korekta</td>
		<td colspan="2"><textarea cols="60" rows="4" name="HINT_rodzaj_dokumentu_korekta"><?php echo $text ?></textarea></td>
		<td>
			<input type="submit" value="Store"/>
		</td>			
	</tr>
<?php 
	if (isset($_POST['HINT_rodzaj_dokumentu_zastepczy'])) {
		$newHint = $_POST['HINT_rodzaj_dokumentu_zastepczy'];
		$newHint = trim($newHint);
		if ($newHint == "") {
			$newHint = null;
		}
		$query = "";
		if (isset($newHint)) {
	$hintId = null;
	$hintText = null;
	$query = " SELECT trn_id, trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_rodzaj_dokumentu_zastepczy'));
	foreach ($result as $res) {
		$hintId = $row[trn_id];
		$hintText = $row[trn_text];
	}
			if (isset($hintId)) {
				if ($newHint != $hintText) {
					$query = " UPDATE prt_translations SET trn_text = '" . $newHint . "' WHERE trn_id = " . $hintId;
				}
			} else {
					$query = " INSERT INTO prt_translations (trn_lng_id, trn_token, trn_text) VALUES (" . $lngId . ", 'HINT_rodzaj_dokumentu_zastepczy', '" . $newHint . "')";
			}
		} else {
	$hintId = null;
	$hintText = null;
	$query = " SELECT trn_id, trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_rodzaj_dokumentu_zastepczy'));
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
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_rodzaj_dokumentu_zastepczy'));
	$text = null;
	foreach ($result as $row) {
		$text = $row[trn_text];
	}
?>
	<tr>
		<td>HINT_rodzaj_dokumentu_zastepczy</td>
		<td colspan="2"><textarea cols="60" rows="4" name="HINT_rodzaj_dokumentu_zastepczy"><?php echo $text ?></textarea></td>
		<td>
			<input type="submit" value="Store"/>
		</td>			
	</tr>
<?php 
	if (isset($_POST['HINT_rodzaj_dokumentu_ostatni_numer'])) {
		$newHint = $_POST['HINT_rodzaj_dokumentu_ostatni_numer'];
		$newHint = trim($newHint);
		if ($newHint == "") {
			$newHint = null;
		}
		$query = "";
		if (isset($newHint)) {
	$hintId = null;
	$hintText = null;
	$query = " SELECT trn_id, trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_rodzaj_dokumentu_ostatni_numer'));
	foreach ($result as $res) {
		$hintId = $row[trn_id];
		$hintText = $row[trn_text];
	}
			if (isset($hintId)) {
				if ($newHint != $hintText) {
					$query = " UPDATE prt_translations SET trn_text = '" . $newHint . "' WHERE trn_id = " . $hintId;
				}
			} else {
					$query = " INSERT INTO prt_translations (trn_lng_id, trn_token, trn_text) VALUES (" . $lngId . ", 'HINT_rodzaj_dokumentu_ostatni_numer', '" . $newHint . "')";
			}
		} else {
	$hintId = null;
	$hintText = null;
	$query = " SELECT trn_id, trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_rodzaj_dokumentu_ostatni_numer'));
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
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_rodzaj_dokumentu_ostatni_numer'));
	$text = null;
	foreach ($result as $row) {
		$text = $row[trn_text];
	}
?>
	<tr>
		<td>HINT_rodzaj_dokumentu_ostatni_numer</td>
		<td colspan="2"><textarea cols="60" rows="4" name="HINT_rodzaj_dokumentu_ostatni_numer"><?php echo $text ?></textarea></td>
		<td>
			<input type="submit" value="Store"/>
		</td>			
	</tr>
<?php 
	if (isset($_POST['HINT_rodzaj_dokumentu_numeracja_rok'])) {
		$newHint = $_POST['HINT_rodzaj_dokumentu_numeracja_rok'];
		$newHint = trim($newHint);
		if ($newHint == "") {
			$newHint = null;
		}
		$query = "";
		if (isset($newHint)) {
	$hintId = null;
	$hintText = null;
	$query = " SELECT trn_id, trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_rodzaj_dokumentu_numeracja_rok'));
	foreach ($result as $res) {
		$hintId = $row[trn_id];
		$hintText = $row[trn_text];
	}
			if (isset($hintId)) {
				if ($newHint != $hintText) {
					$query = " UPDATE prt_translations SET trn_text = '" . $newHint . "' WHERE trn_id = " . $hintId;
				}
			} else {
					$query = " INSERT INTO prt_translations (trn_lng_id, trn_token, trn_text) VALUES (" . $lngId . ", 'HINT_rodzaj_dokumentu_numeracja_rok', '" . $newHint . "')";
			}
		} else {
	$hintId = null;
	$hintText = null;
	$query = " SELECT trn_id, trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_rodzaj_dokumentu_numeracja_rok'));
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
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_rodzaj_dokumentu_numeracja_rok'));
	$text = null;
	foreach ($result as $row) {
		$text = $row[trn_text];
	}
?>
	<tr>
		<td>HINT_rodzaj_dokumentu_numeracja_rok</td>
		<td colspan="2"><textarea cols="60" rows="4" name="HINT_rodzaj_dokumentu_numeracja_rok"><?php echo $text ?></textarea></td>
		<td>
			<input type="submit" value="Store"/>
		</td>			
	</tr>
<tr><td></td><td></td><td></td><td></td></tr>
<?php 
	if (isset($_POST['HINT_rodzaj_dokumentu_grupa_dokumentow'])) {
		$newHint = $_POST['HINT_rodzaj_dokumentu_grupa_dokumentow'];
		$newHint = trim($newHint);
		if ($newHint == "") {
			$newHint = null;
		}
		$query = "";
		if (isset($newHint)) {
	$hintId = null;
	$hintText = null;
	$query = " SELECT trn_id, trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_rodzaj_dokumentu_grupa_dokumentow'));
	foreach ($result as $res) {
		$hintId = $row[trn_id];
		$hintText = $row[trn_text];
	}
			if (isset($hintId)) {
				if ($newHint != $hintText) {
					$query = " UPDATE prt_translations SET trn_text = '" . $newHint . "' WHERE trn_id = " . $hintId;
				}
			} else {
					$query = " INSERT INTO prt_translations (trn_lng_id, trn_token, trn_text) VALUES (" . $lngId . ", 'HINT_rodzaj_dokumentu_grupa_dokumentow', '" . $newHint . "')";
			}
		} else {
	$hintId = null;
	$hintText = null;
	$query = " SELECT trn_id, trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_rodzaj_dokumentu_grupa_dokumentow'));
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
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_rodzaj_dokumentu_grupa_dokumentow'));
	$text = null;
	foreach ($result as $row) {
		$text = $row[trn_text];
	}
?>
	<tr>
		<td>HINT_rodzaj_dokumentu_grupa_dokumentow</td>
		<td colspan="2"><textarea cols="60" rows="4" name="HINT_rodzaj_dokumentu_grupa_dokumentow"><?php echo $text ?></textarea></td>
		<td>
			<input type="submit" value="Store"/>
		</td>			
	</tr>
<tr><td></td><td></td><td></td><td></td></tr>
<?php 
	if (isset($_POST['HINT_rodzaj_dokumentu_dokumenty_ksiegowe'])) {
		$newHint = $_POST['HINT_rodzaj_dokumentu_dokumenty_ksiegowe'];
		$newHint = trim($newHint);
		if ($newHint == "") {
			$newHint = null;
		}
		$query = "";
		if (isset($newHint)) {
	$hintId = null;
	$hintText = null;
	$query = " SELECT trn_id, trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_rodzaj_dokumentu_dokumenty_ksiegowe'));
	foreach ($result as $res) {
		$hintId = $row[trn_id];
		$hintText = $row[trn_text];
	}
			if (isset($hintId)) {
				if ($newHint != $hintText) {
					$query = " UPDATE prt_translations SET trn_text = '" . $newHint . "' WHERE trn_id = " . $hintId;
				}
			} else {
					$query = " INSERT INTO prt_translations (trn_lng_id, trn_token, trn_text) VALUES (" . $lngId . ", 'HINT_rodzaj_dokumentu_dokumenty_ksiegowe', '" . $newHint . "')";
			}
		} else {
	$hintId = null;
	$hintText = null;
	$query = " SELECT trn_id, trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_rodzaj_dokumentu_dokumenty_ksiegowe'));
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
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_rodzaj_dokumentu_dokumenty_ksiegowe'));
	$text = null;
	foreach ($result as $row) {
		$text = $row[trn_text];
	}
?>
	<tr>
		<td>HINT_rodzaj_dokumentu_dokumenty_ksiegowe</td>
		<td colspan="2"><textarea cols="60" rows="4" name="HINT_rodzaj_dokumentu_dokumenty_ksiegowe"><?php echo $text ?></textarea></td>
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
					$values = array('portlet_css');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_portlet_css)) {
						$values = array($postValue, 'portlet_css');
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
					$values = array('portlet_css');
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_portlet_css)) {
						$values = array($postValue, 'portlet_css');
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


