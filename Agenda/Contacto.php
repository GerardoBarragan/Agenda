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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO contacto (Nombre, `Apellido paterno`, `Apellido Materno`, Telefono, Domicilio, gruposid) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['Nombre'], "text"),
                       GetSQLValueString($_POST['Apellido_paterno'], "text"),
                       GetSQLValueString($_POST['Apellido_Materno'], "text"),
                       GetSQLValueString($_POST['Telefono'], "int"),
                       GetSQLValueString($_POST['Domicilio'], "text"),
                       GetSQLValueString($_POST['gruposid'], "int"));

  mysql_select_db($database_Agendadb, $Agendadb);
  $Result1 = mysql_query($insertSQL, $Agendadb) or die(mysql_error());

  $insertGoTo = "listacontacto.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_Agendadb, $Agendadb);
$query_selecGrupos = "SELECT * FROM grupos ORDER BY grupos.`Grupo desc`";
$selecGrupos = mysql_query($query_selecGrupos, $Agendadb) or die(mysql_error());
$row_selecGrupos = mysql_fetch_assoc($selecGrupos);
$totalRows_selecGrupos = mysql_num_rows($selecGrupos);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html>
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
  <h1>Agregar contacto</h1>
 

<?php
mysql_free_result($selecGrupos);
?>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Nombre:</td>
      <td><input type="text" name="Nombre" value="" size="32" required/></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Apellido paterno:</td>
      <td><input type="text" name="Apellido_paterno" value="" size="32" required/></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Apellido Matecolrno:</td>
      <td><input type="text" name="Apellido_Materno" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Telefono:</td>
      <td><input type="text" name="Telefono" value="" size="32" required/></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Domicilio:</td>
      <td><input type="text" name="Domicilio" value="" size="32" required/></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Grupos:</td>
      <td><select name="gruposid">
        <?php 
do {  
?>
        <option value="<?php echo $row_selecGrupos['idgrupo']?>" ><?php echo $row_selecGrupos['Grupo desc']?></option>
        <?php
} while ($row_selecGrupos = mysql_fetch_assoc($selecGrupos));

?>
      </select></td>
    </tr>
    <tr> </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input class="btn btn-small btn-primary" type="submit" value="Agregar"</td><td><a href="registrar.php" class=" btn btn-danger btn btn-small">cerrar sesion</a></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
  
</form>
<p>&nbsp;</p>
