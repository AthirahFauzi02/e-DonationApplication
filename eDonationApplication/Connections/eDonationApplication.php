<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_eDonationApplication = "localhost";
$database_eDonationApplication = "e-donation application";
$username_eDonationApplication = "root";
$password_eDonationApplication = "";
$eDonationApplication = mysql_pconnect($hostname_eDonationApplication, $username_eDonationApplication, $password_eDonationApplication) or trigger_error(mysql_error(),E_USER_ERROR); 
?>