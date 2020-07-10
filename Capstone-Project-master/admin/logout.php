<?php
session_start();
//clears session variable
$_SESSION['login']=="";

session_unset();
$_SESSION['action1']="You have logged out successfully..!";
?>
<script language="javascript">
document.location="adminlogin.php";
</script>
