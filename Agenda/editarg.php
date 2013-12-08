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
  $updateSQL = sprintf("UPDATE grupos SET `Grupo desc`=%s WHERE idgrupo=%s",
                       GetSQLValueString($_POST['Grupo_desc'], "text"),
                       GetSQLValueString($_POST['idgrupo'], "int"));

  mysql_select_db($database_Agendadb, $Agendadb);
  $Result1 = mysql_query($updateSQL, $Agendadb) or die(mysql_error());

  $updateGoTo = "Lista.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$varGrupo_getgrupo = "0";
if (isset($_GET['id_g'])) {
  $varGrupo_getgrupo = $_GET['id_g'];
}
mysql_select_db($database_Agendadb, $Agendadb);
$query_getgrupo = sprintf("SELECT * FROM grupos WHERE grupos.idgrupo=%s", GetSQLValueString($varGrupo_getgrupo, "int"));
$getgrupo = mysql_query($query_getgrupo, $Agendadb) or die(mysql_error());
$row_getgrupo = mysql_fetch_assoc($getgrupo);
$totalRows_getgrupo = mysql_num_rows($getgrupo);
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
  <h1>Editar Grupo</h1>


  <?php
mysql_free_result($getgrupo);
?>
  <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
    <table align="center">
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">Nombre del grupo:</td>
        <td><input type="text" name="Grupo_desc" value="<?php echo htmlentities($row_getgrupo['Grupo desc'], ENT_COMPAT, ''); ?>" size="32" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">&nbsp;</td>
        <td><input type="submit" value="Actualizar registro" /></td>
      </tr>
    </table>
    <input type="hidden" name="MM_update" value="form1" />
    <input type="hidden" name="idgrupo" value="<?php echo $row_getgrupo['idgrupo']; ?>" />
  </form>
  <p>&nbsp;</p>
