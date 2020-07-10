<?php
session_start();
include("dbconnection.php");
?>


<!DOCTYPE html>
<html>
<head>
<title>Admin Login Page</title>
<link rel="stylesheet" href="css/style1.css">
</head>
<body style="background-color:#bdc3c7">
	<div id="main-wrapper">
	<center><h2>Admin Login Form</h2></center>
			<div class="imgcontainer">
				<img src="logo100.png" alt="Avatar" class="avatar">
			</div>
		<form action="" method="post">
<?php
if(isset($_POST['login']))
			{
	//gets username and password from input field
				@$username=$_POST['username'];
				@$password=$_POST['password'];
	//checks whether username and password exist in db
				$query = "select * from admin where name='$username' and password='$password' ";
				//echo $query;
				$query_run = mysqli_query($con,$query);
				//echo mysql_num_rows($query_run);
				if($query_run)
				{
					if(mysqli_num_rows($query_run)>0)
					{
					$row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);

						//updates session variables
					$_SESSION['name'] = $username;
					$_SESSION['password'] = $password;
					$_SESSION['login'] = "1";
					header( "Location: manage-patients.php");
					echo '<script type="text/javascript">alert("Database Worked")</script>';

					}
					else
					{
						echo '<script type="text/javascript">alert("No such admin exists. Invalid Credentials")</script>';
					}
				}
				else
				{
					echo '<script type="text/javascript">alert("Database Error")</script>';
				}
			}
			else
			{
			}
			?>
			<div class="inner_container">
				<label><b>Username</b></label>
				<input type="text" placeholder="Enter Username" name="username" required>
				<label><b>Password</b></label>
				<input type="password" placeholder="Enter Password" name="password" required>
				<button class="login_button" name="login" type="submit">Login</button>

				<a href="https://ontario-shores.herokuapp.com/frontpage.php"><button type="button" class="back_btn">Back</button></a>
			</div>
		</form>

	</div>
</body>
</html>
