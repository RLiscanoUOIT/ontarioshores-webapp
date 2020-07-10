<?php
session_start();
//resets session value to validate login
$_SESSION['login']=="";

session_unset();
$_SESSION['action1']="You have logged out successfully..!";
?>
<script language="javascript">
document.location="caregiverlogin.php";
</script>
