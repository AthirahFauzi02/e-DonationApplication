<?php require_once('Connections/eDonationApplication.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "login.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "CoopMember";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "ApplicantMainMenu.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
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

$colname_Recordset1 = "-1";
if (isset($_GET['ApplicantIDNo'])) {
  $colname_Recordset1 = $_GET['ApplicantIDNo'];
}
mysql_select_db($database_eDonationApplication, $eDonationApplication);
$query_Recordset1 = sprintf("SELECT * FROM applicantinformation WHERE ApplicantIDNo = %s", GetSQLValueString($colname_Recordset1, "text"));
$Recordset1 = mysql_query($query_Recordset1, $eDonationApplication) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_eDonationApplication, $eDonationApplication);
$query_Recordset1 = "SELECT * FROM applicantinformation";
$Recordset1 = mysql_query($query_Recordset1, $eDonationApplication) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
?>
<!DOCTYPE html>
<html>
<head>
<style>
.button {
	display: inline-block;
	font-size: 18px;
	cursor: pointer;
	text-align: center;
	text-decoration: none;
	outline: none;
	color: #fff;
	background-color: #060505;
	border: none;
	border-radius: 20px;
	box-shadow: 0 9px #999;
	padding-top: 5px;
	padding-right: 20px;
	padding-bottom: 10px;
	padding-left: 15px;
}

.button:hover {background-color: #3e8e41}

.button:active {
  background-color: #3e8e41;
  box-shadow: 0 5px #666;
  transform: translateY(4px);
}
input[type=text] {
	width: 20%;
	box-sizing: border-box;
	border-radius: 6px;
	height: 30px;
	margin-top: 5px;
	margin-right: 0;
	margin-bottom: 5px;
	margin-left: 0;
	padding-top: 8px;
	padding-right: 5px;
	padding-bottom: 8px;
	padding-left: 10px;
}

* {
	box-sizing: border-box;
	border-top-color: #FFF;
	border-right-color: #FFF;
	border-bottom-color: #FFF;
	border-left-color: #FFF;
}

body {
  font-family: Arial;
  padding: 10px;
  background: #f1f1f1;
}

/* Header/Blog Title */
.header {
  padding: 30px;
  text-align: center;
  background: white;
}

.header h1 {
  font-size: 50px;
}

/* Style the top navigation bar */
.topnav {
  overflow: hidden;
  background-color: #333;
}

/* Style the topnav links */
.topnav a {
  float: left;
  display: block;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

/* Change color on hover */
.topnav a:hover {
  background-color: #ddd;
  color: black;
}

/* Create two unequal columns that floats next to each other */
/* Left column */
.leftcolumn {
	float: left;
	width: 100%;
}

/* Right column */
.rightcolumn {
  float: left;
  width: 25%;
  background-color: #f1f1f1;
  padding-left: 20px;
}

/* Fake image */
.fakeimg {
	background-color: #aaa;
	width: 100%;
	padding: 20px;
}

/* Add a card effect for articles */
.card {
  background-color: white;
  padding: 20px;
  margin-top: 20px;
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}

/* Footer */
.footer {
  padding: 20px;
  text-align: center;
  background: #ddd;
  margin-top: 20px;
}
ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  background-color: #333;
}

li {
  float: left;
}

li a, .dropbtn {
  display: inline-block;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

li a:hover, .dropdown:hover .dropbtn {
  background-color: red;
}

li.dropdown {
  display: inline-block;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  text-align: left;
}

.dropdown-content a:hover {background-color: #f1f1f1;}

.dropdown:hover .dropdown-content {
  display: block;


/* Responsive layout - when the screen is less than 800px wide, make the two columns stack on top of each other instead of next to each other */
@media screen and (max-width: 800px) {
  .leftcolumn, .rightcolumn {   
    width: 100%;
    padding: 0;
  }
}

/* Responsive layout - when the screen is less than 400px wide, make the navigation links stack on top of each other instead of next to each other */
@media screen and (max-width: 400px) {
  .topnav a {
    float: none;
    width: 100%;
  }
}
</style>
</head>
<body>
<div class="header">
  <h1 align="left"> <img src="logo.png" alt="" width="179" height="128" align="left">e-Donation Application</h1>
  <p align="left">Koperasi Kolej Profesional Mara Beranang</p>
</div>
<ul>
  <li><a href="MemberMainMenu.php">Main Menu</a></li>
  <li></li>
  <li class="dropdown">
    <a href="javascript:void(0)" class="dropbtn">My Account</a>
    <div class="dropdown-content">
    
    <a href="NewDonationRequest1.php">Add New Donation Request</a>
      <a href="UpdateDonationRequestList.php">Donation Approval Status</a>
      <a href="DeleteDonationRequest.php">Delete Donation Request</a>
      <a href="DonationRequestReport.php">Donation Request Report</a>
      <a href="<?php echo $logoutAction ?>">Logout</a>
    </div>
  </li>
</ul>

<div class="row">
  <div class="leftcolumn">
    <div class="card">
    <form method="POST" name="form1" id="form1">
      <h2><font size="3">Welcome, <?php echo $_SESSION['MM_Username']; ?></font></h2>
      <p align="center"><font size="5">Main Menu</font></p>
      <table align="center" width="595" border="1">
        <tr>
          <th width="125" scope="col"><img src="Edit-Male-User.png" width="117" height="124" align="middle"></th>
          <th width="160" scope="col"><a href="NewDonationRequest.php"><img src="698913-icon-81-document-add-512.png" width="127" height="127"></a></th>
          <th width="156" scope="col"><a href="UpdateDonationRequestList.php"><img src="tender.png" width="125" height="112"></a></th>
          </tr>
        <tr>
          <td  align="center">Update Information, <a href="UpdateInformation1.php? ApplicantIDNo=<?php echo $_SESSION['MM_Username']; ?>"><br>
              <?php echo $_SESSION['MM_Username']; ?></a>
            <input type="hidden" name="ApplicantIDNo"></td>
          <td  align="center"><a href="NewDonationRequest1.php">Add New Donation Request</a></td>
          <td align="center"><a href="UpdateDonationRequestList.php"></a><a href="UpdateDonationRequestList.php">Update Donation Request Approval Status</a></td>
          </tr>
      </table>
      <div align="center">
        <table width="395" border="1">
          <tr>
            <th scope="col"><div align="center"><a href="DeleteDonationRequest.php"><img src="2.png" width="114" height="118"></a></div></th>
            <th scope="col"><div align="center"><a href="DonationRequestReport.php"><img src="call-report-icon-3.png" width="111" height="121"></a></div></th>
            </tr>
          <tr>
            <td><div align="center"><a href="DeleteDonationRequest.php">Delete Donation Request</a></div></td>
            <td><div align="center"><a href="DonationRequestReport.php">Donation Request Report</a></div></td>
            </tr>
        </table>
      </div>
      <p>&nbsp;</p>
      <p align="center">&nbsp;</p>
      </form>
    </div>
  </div>
  <div class="rightcolumn">
    <p>&nbsp;</p>
    <p>&nbsp;</p>
  </div>
</div>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
