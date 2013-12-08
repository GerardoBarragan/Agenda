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

$varContacto_seleccontacto = "0";
if (isset($_GET['id_c'])) {
  $varContacto_seleccontacto = $_GET['id_c'];
}
mysql_select_db($database_Agendadb, $Agendadb);
$query_seleccontacto = sprintf("SELECT * FROM contacto, grupos WHERE contacto.Idcontacto=%s and grupos.idgrupo=contacto.gruposid", GetSQLValueString($varContacto_seleccontacto, "int"));
$seleccontacto = mysql_query($query_seleccontacto, $Agendadb) or die(mysql_error());
$row_seleccontacto = mysql_fetch_assoc($seleccontacto);
$totalRows_seleccontacto = mysql_num_rows($seleccontacto);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>
<table width="436" height="246" border="1">
  <tr>
    <td width="92">ID</td>
    <td width="156"><?php echo $row_seleccontacto['Idcontacto']; ?></td>
  </tr>
  <tr>
    <td>Nombre</td>
    <td><?php echo $row_seleccontacto['Nombre']; ?></td>
  </tr>
  <tr>
    <td>Ap Paterno</td>
    <td><?php echo $row_seleccontacto['Apellido paterno']; ?></td>
  </tr>
  <tr>
    <td>Ap Materno</td>
    <td><?php echo $row_seleccontacto['Apellido Materno']; ?></td>
  </tr>
  <tr>
    <td>Telefono</td>
    <td><?php echo $row_seleccontacto['Telefono']; ?></td>
  </tr>
  <tr>
    <td>Domicilio</td>
    <td><?php echo $row_seleccontacto['Domicilio']; ?></td>
  </tr>
  <tr>
    <td>Grupos</td>
    <td><?php echo $row_seleccontacto['Grupo desc']; ?></td>
  </tr>
  <tr>
    <td>Opciones</td>
   <td><a href="listacontacto.php?id_c=<?php echo $row_seleccontacto['Idcontacto']; ?>" class= "btn btn-success btn btn-small">Regresar</a> 
	  </td>
  </tr>
</table>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="../../assets/js/html5shiv.js"></script>
      <script src="../../assets/js/respond.min.js"></script>

 <![endif]-->


<?php
mysql_free_result($seleccontacto);
?>
