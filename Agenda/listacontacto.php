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

$maxRows_seleccontacto = 10;
$pageNum_seleccontacto = 0;
if (isset($_GET['pageNum_seleccontacto'])) {
  $pageNum_seleccontacto = $_GET['pageNum_seleccontacto'];
}
$startRow_seleccontacto = $pageNum_seleccontacto * $maxRows_seleccontacto;

mysql_select_db($database_Agendadb, $Agendadb);
$query_seleccontacto = "SELECT * FROM contacto, grupos WHERE contacto.gruposid=grupos.idgrupo";
$query_limit_seleccontacto = sprintf("%s LIMIT %d, %d", $query_seleccontacto, $startRow_seleccontacto, $maxRows_seleccontacto);
$seleccontacto = mysql_query($query_limit_seleccontacto, $Agendadb) or die(mysql_error());
$row_seleccontacto = mysql_fetch_assoc($seleccontacto);

if (isset($_GET['totalRows_seleccontacto'])) {
  $totalRows_seleccontacto = $_GET['totalRows_seleccontacto'];
} else {
  $all_seleccontacto = mysql_query($query_seleccontacto);
  $totalRows_seleccontacto = mysql_num_rows($all_seleccontacto);
}
$totalPages_seleccontacto = ceil($totalRows_seleccontacto/$maxRows_seleccontacto)-1;
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
 <script language="JavaScript" type="text/javascript"> 
<!-- 
 function Confirmar(frm) { 

var borrar = confirm("Estas seguro que quieres eliminar este contacto?"); 

return borrar; //true o false 
} 
//--> 
</script> 

  </head>
<h1>Contactos</h1>

<body><table class="table table-hover">
  <tr>
    <td>ID</td>
    <td>Nombre</td>
    <td>Ap Paterno</td>
    <td>Ap Materno</td>
    <td>Telefono</td>
    <td>Domicilio</td>
    <td>Grupos</td>
    <td><p>Opciones</p></td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_seleccontacto['Idcontacto']; ?></td>
      <td><?php echo $row_seleccontacto['Nombre']; ?></td>
      <td><?php echo $row_seleccontacto['Apellido paterno']; ?></td>
      <td><?php echo $row_seleccontacto['Apellido Materno']; ?></td>
      <td><?php echo $row_seleccontacto['Telefono']; ?></td>
      <td><?php echo $row_seleccontacto['Domicilio']; ?></td>
      <td><?php echo $row_seleccontacto['Grupo desc']; ?></td>
      <td><a href="editarc.php?id_c=<?php echo $row_seleccontacto['Idcontacto']; ?>" class= "btn btn-success btn btn-small">Editar</a> 
	  </td>
      
       <td><a href="eliminar.php?id_c=<?php echo $row_seleccontacto['Idcontacto']; ?>" class= "btn btn-warning btn btn-small" onClick='return Confirmar(this.form)'>Eliminar</a> 
       
       <td><a href="verc.php?id_c=<?php echo $row_seleccontacto['Idcontacto']; ?>" class= "btn btn-warning btn btn-small" >Ver</a> 
	  </td>
      
    </tr>
    <?php } while ($row_seleccontacto = mysql_fetch_assoc($seleccontacto)); ?>
</table>

<body>
<p><a href="Contacto.php" class="btn btn-small btn-primary">Agregar Contacto</a><a href="registrar.php" class=" btn btn-danger btn btn-small">Cerrar sesion</a></td></p>
</body>
</html>
<?php
mysql_free_result($seleccontacto);
?>
