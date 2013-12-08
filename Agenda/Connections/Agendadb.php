<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_Agendadb = "localhost";
$database_Agendadb = "agenda";
$username_Agendadb = "root";
$password_Agendadb = "gerabarragan";
$Agendadb = mysql_pconnect($hostname_Agendadb, $username_Agendadb, $password_Agendadb) or trigger_error(mysql_error(),E_USER_ERROR); 
?>