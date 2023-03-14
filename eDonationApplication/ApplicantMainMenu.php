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
if (isset($_SESSION['ApplicantIDNo'])) {
  $colname_Recordset1 = $_SESSION['ApplicantIDNo'];
}
mysql_select_db($database_eDonationApplication, $eDonationApplication);
$query_Recordset1 = sprintf("SELECT * FROM applicantinformation WHERE ApplicantIDNo = %s", GetSQLValueString($colname_Recordset1, "text"));
$Recordset1 = mysql_query($query_Recordset1, $eDonationApplication) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_Recordset1 = "-1";
if (isset($_SESSION['ApplicantIDNo'])) {
  $colname_Recordset1 = $_SESSION['ApplicantIDNo'];
}
mysql_select_db($database_eDonationApplication, $eDonationApplication);
$query_Recordset1 = sprintf("SELECT * FROM applicantinformation WHERE ApplicantIDNo = %s", GetSQLValueString($colname_Recordset1, "text"));
$Recordset1 = mysql_query($query_Recordset1, $eDonationApplication) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

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
  <li><a href="ApplicantMainMenu.php">Main Menu</a></li>
  <li></li>
  <li class="dropdown">
    <a href="javascript:void(0)" class="dropbtn">My Account</a>
    <div class="dropdown-content">
      <a href="NewDonationRequest.php">Add New Donation Request</a>
      
      <a href="ViewDonationApprovalStatus.php">View Donation Approval Status</a>
      <a href="<?php echo $logoutAction ?>">Logout</a>
    </div>
  </li>
</ul>

<div class="row">
  <div class="leftcolumn">
    <div class="card">
     <form method="POST" name="form1" id="form1">
        <p><font size="3">Welcome, </font>
          <?php echo $_SESSION['MM_Username']; ?>
        <p align="center"><font size="5">Main Menu</font></p>
      <table align="center" width="522" border="1">
        <tr>
          <th width="140" scope="col"><a href="UpdateInformation.php"><img src="Edit-Male-User.png" width="119" height="129"></a></th>
          <th width="129" scope="col"><a href="NewDonationRequest.php"><img src="698913-icon-81-document-add-512.png" width="126" height="126"></a></th>
          <th width="136" scope="col"><img src="1657165-200.png" width="119" height="119"></th>
        </tr>
        <tr>
          <td height="40"  align="center">Update Information,<a href="UpdateInformation.php? ApplicantIDNo=<?php echo $_SESSION['MM_Username']; ?>"><br>
              <?php echo $_SESSION['MM_Username']; ?></a>
          <input type="hidden" name="ApplicantIDNo">
          </td>
          <td align="center"><a href="NewDonationRequest.php">Add New Donation Request</a></td>
          <td align="center"><a href="ViewDonationApprovalStatus.php">View Donation Approval Status</a></td>
        </tr>
      </table>
      <p align="center">&nbsp;</p>
      </form>
    </div>
  </div>
  <div class="rightcolumn"></div>
</div>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
