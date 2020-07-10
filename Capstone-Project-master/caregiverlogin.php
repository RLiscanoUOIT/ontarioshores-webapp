<?php
	session_start();
	require_once('dbconfig/config.php');
?>
<!DOCTYPE html>
<html>
<head>
<title>Login Page</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body style="background-color:#bdc3c7">
	<div id="main-wrapper">
	<center><h2>Caregiver Login Form</h2></center>
			<div class="imgcontainer">
				<img src="logo100.png" alt="Avatar" class="avatar">
			</div>
		<form action="" method="post">
<?php
			if(isset($_POST['login']))
			{
				//gets username and password from input fields for a SQL query
				@$username=$_POST['username'];
				@$password=$_POST['password'];
				$query = "select * from caregiver where name='$username' and password='$password' ";
				$query_run = mysqli_query($con,$query);
				//if name and password exists, enter if statement
				if($query_run)
				{
					//if there is more than 0 rows, enter if statement
					if(mysqli_num_rows($query_run)>0)
					{
					$row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
					//assign session values
					$_SESSION['name'] = $username;
					$_SESSION['password'] = $password;
					$_SESSION['login'] = "1";
					$_SESSION['pid'] = $row['patientid'];
					
					//take user to upload page
					header( "Location: upload.php");
					echo '<script type="text/javascript">alert("Database Worked")</script>';

					}
					else
					{
						//in case of incorrect credentials
						echo '<script type="text/javascript">alert("No such User exists. Invalid Credentials")</script>';
					}
				}
				else
				{
					//in case of database connection error
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
				<a href="frontpage.php"><button type="button" class="back_btn">Back</button></a>
			</div>
		</form>
	</div>
</body>
</html>
