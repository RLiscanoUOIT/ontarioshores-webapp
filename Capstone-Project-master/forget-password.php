<?php
	session_start();
    require_once('dbconfig/config.php');
  
 
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require 'vendor\autoload.php';

    /* Create a new PHPMailer object. */
    $mail = new PHPMailer();

    /* Set the mail sender. */
    $mail->setFrom('angela.tabafunda@ontariotechu.net', 'Darth Vader');

    /* Add a recipient. */
    $mail->addAddress('angela.tabafunda@ontariotechu.net', 'Emperor');

    /* Set the subject. */
    $mail->Subject = 'Force';

    /* Set the mail message body. */
    $mail->Body = 'There is a great disturbance in the Force.';

    /* Finally send the mail. */
    if (!$mail->send())
    {
    /* PHPMailer error. */
    echo $mail->ErrorInfo;
    }  
?>

<!DOCTYPE html>
<html>
<head>
<title>Login Page</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body style="background-color:#bdc3c7">
	<div id="main-wrapper">
	<center><h2>Welcome</h2></center>
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
				$caregiver=1;
				$query = "select * from log_in where username='$username' and password='$password' ";
				$query_run = mysqli_query($con,$query);
				//if name and password exists, enter if statement
				if($query_run)
				{
					//if there is more than 0 rows, enter if statement
					if(mysqli_num_rows($query_run)>0)
					{
					$row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
					//assign session values
					$_SESSION['username'] = $username;
					$_SESSION['password'] = $password;
					$_SESSION['login'] = "1";
					//$_SESSION['pid'] = $row['patientid'];
					
					//take user to upload page
					if($row['caregiver']==1){
						$_SESSION['pid'] = $row['patientid'];
						header( "Location: upload.php");
						echo '<script type="text/javascript">alert("Database Worked")</script>';
					}
					else if($row['admin']==1){
						header( "Location: admin/manage-patients.php");
						echo '<script type="text/javascript">alert("Database Worked")</script>';
					}else if($row['staff']==1){
						header( "Location: staff/manage-patients.php");
						echo '<script type="text/javascript">alert("Database Worked")</script>';
					}
					else
					{
						//in case theres no permissions attatched
						echo '<script type="text/javascript">alert("User does not have any permissions.")</script>';
					}

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
