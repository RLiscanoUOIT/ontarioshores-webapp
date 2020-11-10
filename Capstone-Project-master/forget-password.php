<?php
	session_start();
    require_once('dbconfig/config.php');
    
    require 'vendor/autoload.php';
    use Mailgun\Mailgun;
    
    // # Instantiate the client.
    // $mgClient = Mailgun::create('45a491a47b86ebd89d61c117a77419bd-ba042922-0a659b6c', 'https://api.mailgun.net/v3/sandboxd0bf7749383345cda13d2f1458f1c2c3.mailgun.org');
    // $domain = "sandboxd0bf7749383345cda13d2f1458f1c2c3.mailgun.org";
    // $params = array(
    //   'from'    => 'Excited User <Hello@sandboxd0bf7749383345cda13d2f1458f1c2c3.mailgun.org>',
    //   'to'      => 'angela.tabafunda@ontariotechu.net',
    //   'subject' => 'Hello',
    //   'text'    => 'Testing some Mailgun awesomness!'
    // );
    
    // # Make the call to the client.
    // $mgClient->messages()->send($domain, $params);
   
?>

<!DOCTYPE html>
<html>
<head>
<title>Login Page</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body style="background-color:#bdc3c7">
	<div id="main-wrapper">
	<center><h3>Forgot your Password?</h3></center>
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
				<label><b>Email</b></label>
				<input type="text" placeholder="Enter Email" name="email" required>
				<label><b>Username</b></label>
				<input type="text" placeholder="Enter Username" name="username" required>
				<button class="reset_btn" name="resetpass" type="submit"> Reset Password</button>
				<a href="frontpage.php"><button type="button" class="back_btn">Back</button></a>
			</div>
		</form>
	</div>
</body>
</html>
