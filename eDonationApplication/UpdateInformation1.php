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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE applicantinformation SET Name=%s, Password=%s, ICNo=%s, PhoneNo=%s, Email=%s, UserType=%s WHERE ApplicantIDNo=%s",
                       GetSQLValueString($_POST['Name'], "text"),
                       GetSQLValueString($_POST['Password'], "text"),
                       GetSQLValueString($_POST['ICNo'], "int"),
                       GetSQLValueString($_POST['PhoneNo'], "int"),
                       GetSQLValueString($_POST['Email'], "text"),
                       GetSQLValueString($_POST['UserType'], "text"),
                       GetSQLValueString($_POST['ApplicantIDNo'], "text"));

  mysql_select_db($database_eDonationApplication, $eDonationApplication);
  $Result1 = mysql_query($updateSQL, $eDonationApplication) or die(mysql_error());
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

$colname_ApplicantInfo = "-1";
if (isset($_GET['ApplicantIDNo'])) {
  $colname_ApplicantInfo = $_GET['ApplicantIDNo'];
}
mysql_select_db($database_eDonationApplication, $eDonationApplication);
$query_ApplicantInfo = sprintf("SELECT * FROM applicantinformation WHERE ApplicantIDNo = %s", GetSQLValueString($colname_ApplicantInfo, "text"));
$ApplicantInfo = mysql_query($query_ApplicantInfo, $eDonationApplication) or die(mysql_error());
$row_ApplicantInfo = mysql_fetch_assoc($ApplicantInfo);
?>
<!DOCTYPE html>
<html>
<head>
<style>
input[type=int] {
	width: 40%;
	box-sizing: border-box;
	border-radius: 6px;
	height: 30px;
	margin-top: 5px;
	margin-right: 0;
	margin-bottom: 5px;
	margin-left: 0;
	padding-top: 8px;
	padding-right: 10px;
	padding-bottom: 8px;
	padding-left: 10px;
}
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
	width: 40%;
	box-sizing: border-box;
	border-radius: 6px;
	height: 30px;
	margin-top: 5px;
	margin-right: 0;
	margin-bottom: 5px;
	margin-left: 0;
	padding-top: 8px;
	padding-right: 10px;
	padding-bottom: 8px;
	padding-left: 10px;
}
input[type=password] {
	width: 40%;
	box-sizing: border-box;
	border-radius: 6px;
	height: 30px;
	margin-top: 5px;
	margin-right: 0;
	margin-bottom: 5px;
	margin-left: 0;
	padding-top: 8px;
	padding-right: 10px;
	padding-bottom: 8px;
	padding-left: 10px;

}
* {
  box-sizing: border-box;
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
  float: right;
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
	float: right;
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
      <h2>UPDATE INFORMATION      </h2>
      <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
        <table align="left">
          <tr valign="baseline">
            <td width="736" height="67" align="left" nowrap>Name:
            <br>
              <input type="text" name="Name" value="<?php echo htmlentities($row_Recordset1['Name'], ENT_COMPAT, ''); ?>" size="32"></td>
          </tr>
          <tr valign="baseline">
            <td height="52" align="left" nowrap>Applicant ID No:<br>
			<?php echo $row_Recordset1['ApplicantIDNo']; ?></td>
          </tr>
          <tr valign="baseline">
            <td height="69" align="left" nowrap>Password:
            <br>
            <input type="text" name="Password" value="<?php echo htmlentities($row_Recordset1['Password'], ENT_COMPAT, ''); ?>" size="32"></td>
          </tr>
          <tr valign="baseline">
            <td height="70" align="left" nowrap>IC No: <br>
            <input name="ICNo" type="int" value="<?php echo $row_Recordset1['ICNo']; ?>" size="32"></td>
          </tr>
          <tr valign="baseline">
            <td height="70" align="left" nowrap>Phone No: <br>
            <input name="PhoneNo" type="int" value="<?php echo $row_Recordset1['PhoneNo']; ?>" size="32"></td>
          </tr>
          <tr valign="baseline">
            <td height="71" align="left" nowrap>Email: <br>
            <input type="text" name="Email" value="<?php echo htmlentities($row_Recordset1['Email'], ENT_COMPAT, ''); ?>" size="32"></td>
          </tr>
          <tr valign="baseline">
            <td align="left" nowrap>User Type: <br>
            <input type="text" name="UserType" value="<?php echo htmlentities($row_Recordset1['UserType'], ENT_COMPAT, ''); ?>" size="32"></td>
          </tr>
          <tr valign="baseline">
            <td align="left" nowrap><input class="button" type="submit" value="Update" button onclick = "myFunction()"></td>
          </tr>
        </table> 
        <input type="hidden" name="MM_update" value="form1">
        <input type="hidden" name="ApplicantIDNo" value="<?php echo $row_Recordset1['ApplicantIDNo']; ?>">
      </form>
      <script>
	  function myFunction()
	  {
		  alert ("Your Information has been update.");
	  }
	  </script>
      <p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
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
