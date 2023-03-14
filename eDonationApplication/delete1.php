<?php require_once('Connections/eDonationApplication.php'); ?>
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

if ((isset($_GET['ProgramID'])) && ($_GET['ProgramID'] != "")) {
  $deleteSQL = sprintf("DELETE FROM donationinformation WHERE ProgramID=%s",
                       GetSQLValueString($_GET['ProgramID'], "int"));

  mysql_select_db($database_eDonationApplication, $eDonationApplication);
  $Result1 = mysql_query($deleteSQL, $eDonationApplication) or die(mysql_error());

  $deleteGoTo = "DeleteDonationRequest.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

if ((isset($_GET['ProgramID'])) && ($_GET['ProgramID'] != "")) {
  $deleteSQL = sprintf("DELETE FROM programinformation WHERE ProgramID=%s",
                       GetSQLValueString($_GET['ProgramID'], "int"));

  mysql_select_db($database_eDonationApplication, $eDonationApplication);
  $Result1 = mysql_query($deleteSQL, $eDonationApplication) or die(mysql_error());

  $deleteGoTo = "DeleteDonationRequest.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}
?>
