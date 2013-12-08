<?php require_once('Connections/Agendadb.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE contacto SET Nombre=%s, `Apellido paterno`=%s, `Apellido Materno`=%s, Telefono=%s, Domicilio=%s, gruposid=%s WHERE Idcontacto=%s",
                       GetSQLValueString($_POST['Nombre'], "text"),
                       GetSQLValueString($_POST['Apellido_paterno'], "text"),
                       GetSQLValueString($_POST['Apellido_Materno'], "text"),
                       GetSQLValueString($_POST['Telefono'], "int"),
                       GetSQLValueString($_POST['Domicilio'], "text"),
                       GetSQLValueString($_POST['gruposid'], "int"),
                       GetSQLValueString($_POST['Idcontacto'], "int"));

  mysql_select_db($database_Agendadb, $Agendadb);
  $Result1 = mysql_query($updateSQL, $Agendadb) or die(mysql_error());

  $updateGoTo = "listacontacto.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$varContacto_seleccontacto = "0";
if (isset($_GET['id_c'])) {
  $varContacto_seleccontacto = $_GET['id_c'];
}
mysql_select_db($database_Agendadb, $Agendadb);
$query_seleccontacto = sprintf("SELECT * FROM contacto, grupos WHERE contacto.Idcontacto=%s and grupos.idgrupo=contacto.gruposid", GetSQLValueString($varContacto_seleccontacto, "int"));
$seleccontacto = mysql_query($query_seleccontacto, $Agendadb) or die(mysql_error());
$row_seleccontacto = mysql_fetch_assoc($seleccontacto);
$totalRows_seleccontacto = mysql_num_rows($seleccontacto);

mysql_select_db($database_Agendadb, $Agendadb);
$query_selecgrupo = "SELECT * FROM grupos";
$selecgrupo = mysql_query($query_selecgrupo, $Agendadb) or die(mysql_error());
$row_selecgrupo = mysql_fetch_assoc($selecgrupo);
$totalRows_selecgrupo = mysql_num_rows($selecgrupo);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="../../assets/js/html5shiv.js"></script>
      <script src="../../assets/js/respond.min.js"></script>
    <![endif]-->
</head>
<h1>Editar Contacto</h1>

<?php
mysql_free_result($seleccontacto);

mysql_free_result($selecgrupo);
?>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Nombre:</td>
      <td><input type="text" name="Nombre" value="<?php echo htmlentities($row_seleccontacto['Nombre'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Apellido paterno:</td>
      <td><input type="text" name="Apellido_paterno" value="<?php echo htmlentities($row_seleccontacto['Apellido paterno'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Apellido Materno:</td>
      <td><input type="text" name="Apellido_Materno" value="<?php echo htmlentities($row_seleccontacto['Apellido Materno'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Telefono:</td>
      <td><input type="text" name="Telefono" value="<?php echo htmlentities($row_seleccontacto['Telefono'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Domicilio:</td>
      <td><input type="text" name="Domicilio" value="<?php echo htmlentities($row_seleccontacto['Domicilio'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Grupos:</td>
      <td><select name="gruposid">
        <?php
do {  
?>
        <option value="<?php echo $row_selecgrupo['idgrupo']?>"<?php if (!(strcmp($row_selecgrupo['idgrupo'], htmlentities($row_seleccontacto['gruposid'])))) {echo "selected=\"selected\"";} ?>><?php echo $row_selecgrupo['Grupo desc']?></option>
        <?php
} while ($row_selecgrupo = mysql_fetch_assoc($selecgrupo));
  $rows = mysql_num_rows($selecgrupo);
  if($rows > 0) {
      mysql_data_seek($selecgrupo, 0);
	  $row_selecgrupo = mysql_fetch_assoc($selecgrupo);
  }
?>
      </select></td>
    </tr>
    <tr> </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input class="btn btn-small btn-primary" type="submit" value="Editar" /></td> 
      </td> <td><a href="registrar.php" class=" btn btn-danger btn btn-small">Cerrar sesion</a></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="Idcontacto" value="<?php echo $row_seleccontacto['Idcontacto']; ?>" />
</form>
<p>&nbsp;</p>
