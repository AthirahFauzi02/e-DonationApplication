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
	
  $logoutGoTo = "MemberMainMenu.php";
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO programinformation (ProgramID, ProgramTitle, AmountOfStudent, DateOfProgram, Organization, letter) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['ProgramID'], "int"),
                       GetSQLValueString($_POST['ProgramTitle'], "text"),
                       GetSQLValueString($_POST['AmountOfStudent'], "int"),
                       GetSQLValueString($_POST['DateOfProgram'], "date"),
                       GetSQLValueString($_POST['Organization'], "text"),
                       GetSQLValueString($_POST['letter'], "text"));

  mysql_select_db($database_eDonationApplication, $eDonationApplication);
  $Result1 = mysql_query($insertSQL, $eDonationApplication) or die(mysql_error());

  $insertGoTo = "ApplicantMainMenu.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO donationinformation (ApplicantIDNo, ProgramID, ApprovalStatus, AmountOfDonation) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['ApplicantIDNo'], "text"),
                       GetSQLValueString($_POST['ProgramID'], "int"),
                       GetSQLValueString($_POST['	ApprovalStatus'], "text"),
                       GetSQLValueString($_POST['AmountOfDonation'], "int"));

  mysql_select_db($database_eDonationApplication, $eDonationApplication);
  $Result1 = mysql_query($insertSQL, $eDonationApplication) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	$target="fileuploader/";
	$target=$target.basename($_FILES['letter']['name']);
	$pic=($_FILES['letter']['name']);
  $insertSQL = sprintf("INSERT INTO programinformation (ProgramID, ProgramTitle, AmountOfStudent, DateOfProgram, Organization, letter) VALUES (%s, %s, %s, %s, %s, %s, '$pic')",
                       GetSQLValueString($_POST['ProgramID'], "int"),
                       GetSQLValueString($_POST['ProgramTitle'], "text"),
                       GetSQLValueString($_POST['AmountOfStudent'], "int"),
                       GetSQLValueString($_POST['DateOfProgram'], "date"),
                       GetSQLValueString($_POST['Organization'], "text"),
                       GetSQLValueString($_POST['letter'], "text"));

  mysql_select_db($database_eDonationApplication, $eDonationApplication);
  $Result1 = mysql_query($insertSQL, $eDonationApplication) or die(mysql_error());

  $insertGoTo = "ApplicantMainMenu.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
  }

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	$target="fileuploader/";
	$target=$target.basename($_FILES['letter']['name']);
	$pic=($_FILES['letter']['name']);
  $insertSQL = sprintf("INSERT INTO programinformation (ProgramID, ProgramTitle, AmountOfStudent, DateOfProgram, Organization, letter) VALUES (%s, %s, %s, %s, %s, %s, '$pic')",
                       GetSQLValueString($_POST['ProgramID'], "int"),
                       GetSQLValueString($_POST['ProgramTitle'], "text"),
                       GetSQLValueString($_POST['AmountOfStudent'], "int"),
                       GetSQLValueString($_POST['DateOfProgram'], "date"),
                       GetSQLValueString($_POST['Organization'], "text"),
                       GetSQLValueString($_POST['letter'], "text"));

  mysql_select_db($database_eDonationApplication, $eDonationApplication);
  $Result1 = mysql_query($insertSQL, $eDonationApplication) or die(mysql_error());

  $insertGoTo = "ApplicantMainMenu.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
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
input[type=date] {
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
      <h2>NEW DONATION REQUEST</h2>
      <form action="<?php echo $editFormAction; ?><?php echo $editFormAction; ?>" name="form1" method="POST">
        <p>
          <label for="	ApplicantIDNo">ID No:<br>
            <input value="<?php echo $_SESSION['MM_Username']; ?>" type="text" id="ApplicantIDNo" name="ApplicantIDNo" readonly>
            <br>
            <br>
          </label>
          <label for="ProgramID">Program ID: <br>
          </label>
          <input value="<?php echo(rand());?>" input type="text" id="ProgramID" name="ProgramID" readonly>
          <br>
        <small><b><font color="#FF0000">*Please remember Program ID for future reference</font></b></small></br>
          <label for="DateOfProgram2"></label>
          <label for="	ApplicantIDNo2"></label>
          <label for="	ApplicantIDNo">  <br>
          </label>
        <p>
          <label for="ProgramTitle">Program Title:*<br>
          </label>
          <input type="text" id="ProgramTitle" name="ProgramTitle">
          <label for="DateOfProgram"><br>
            <br>
        Date of Program:* <br> 
          </label>
          <input type="date" id="DateOfProgram" name="DateOfProgram">
          <label for="AmountOfStudent"><br>
            <br>
            Amount of Student Involve:(eg: 800)*<br>
          </label>
          <input type="int" id="AmountOfStudent" name="AmountOfStudent">        
        <p>
          <label for="AmountOfDonation">Amount of Donation:(eg: 1000)* <br>
          </label>
          <input type="int" id="AmountOfDonation" name="AmountOfDonation">
        
        <p>
          <label for="Organization">Organization/Department:* <br>
            <select id="Organization" name="Organization">
              <option value="ScienceQuantitative">Science Quantitatif Dept</option>
              <option value="AccountingDept">Accounting Dept</option>
              <option value="AgroBusinessDept">Agro Business Dept</option>
              <option value="GeneralStudyDept">General Study Dept</option>
              <option value="BusinessStudyDept">Business Study Dept</option>
              <option value="Perdiqma">Perdiqma</option>
              <option value="MPP">MPP</option>
              <option value="Peers">Peers</option>
              <option value="Wataniah">Wataniah</option>
            </select>
          <br></label>
        <p>
          <label for="letter">Request Letter:*<br></label>
        <input name="letter" type="file" id="letter" >
        <br>
        <strong><small><font color="#FF0000">*Attachment must be in .doc or .pdf format<br>
*Must be less than 60Kb</font></small></strong>
        <p>Approval Status:
        <br>
          <input type="text" id="ApprovalStatus" name="	ApprovalStatus" value="Pending" readonly>
        <p><strong><small><font color="#FF0000">*Please fill in all the required information</font></small></strong>
        <p>
          <button onclick = "myFunction()" class="button">Request</button>
          <input type="hidden" name="MM_insert" value="form1">
      </form>
      <p>
        <script>
	  function myFunction()
	  {
		  alert ("Thank you for your request. Please remember the Program ID for your aprroval status.");
	  }
	    </script>
      </p>
      <p>&nbsp;</p>
    </div>
  </div>
  <div class="rightcolumn"></div>
</div>
</body>
</html>