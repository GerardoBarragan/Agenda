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

$maxRows_getGrupo = 10;
$pageNum_getGrupo = 0;
if (isset($_GET['pageNum_getGrupo'])) {
  $pageNum_getGrupo = $_GET['pageNum_getGrupo'];
}
$startRow_getGrupo = $pageNum_getGrupo * $maxRows_getGrupo;

mysql_select_db($database_Agendadb, $Agendadb);
$query_getGrupo = "SELECT * FROM grupos";
$query_limit_getGrupo = sprintf("%s LIMIT %d, %d", $query_getGrupo, $startRow_getGrupo, $maxRows_getGrupo);
$getGrupo = mysql_query($query_limit_getGrupo, $Agendadb) or die(mysql_error());
$row_getGrupo = mysql_fetch_assoc($getGrupo);

if (isset($_GET['totalRows_getGrupo'])) {
  $totalRows_getGrupo = $_GET['totalRows_getGrupo'];
} else {
  $all_getGrupo = mysql_query($query_getGrupo);
  $totalRows_getGrupo = mysql_num_rows($all_getGrupo);
}
$totalPages_getGrupo = ceil($totalRows_getGrupo/$maxRows_getGrupo)-1;
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
   <h1>Grupos</h1>
  
<body><table width="43%" class="table table-hover">
  <tr>
    <td width="3%">Id</td>
    <td width="22%">Grupo</td>
    <td width="75%">Opciones</td>
  </tr>
  <?php do { ?>
    <tr>
      <td height="45"><?php echo $row_getGrupo['idgrupo']; ?></td>
      <td><?php echo $row_getGrupo['Grupo desc']; ?></td>
      <td><a href="editarg.php?g_id=<?php echo $row_getGrupo['idgrupo']; ?>" class="btn btn-success btn btn-small">Editar</a></td>
    </tr>
    <?php } while ($row_getGrupo = mysql_fetch_assoc($getGrupo)); ?>
</table>
 <a href="Grupo_add.php" class="btn btn-small btn-primary">Agregar Grupo</a>
   

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="//code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
</body>
</html>
<?php
mysql_free_result($getGrupo);
?>
