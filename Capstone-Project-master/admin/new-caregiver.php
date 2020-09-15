<?php
	session_start();
	include'dbconnection.php';
	//ensuring user is logged in
if($_SESSION['login']!="1"){
	header( "Location: adminlogin.php");
}
				if(isset($_POST['submit']))
				{
                    //gets input field values
                    $name=$_POST['name'];
                    $username=$_POST['username'];
                    $password=$_POST['password'];
					$email=$_POST['email'];
					$cpassword=$_POST['cpassword'];
					$pid=$_POST['patient_id'];
	//ensures password is same as confirmed password
					        if($password==$cpassword)
					        {
					          //echo $query;
					        $query_run=mysqli_query($con,"select * from log_in where username='$username'");
					        //echo mysql_num_rows($query_run);
					        if($query_run)
					          {
					            if(mysqli_num_rows($query_run)>0)
					            {
					              echo '<script type="text/javascript">alert("This Username Already exists.. Please try another username!")</script>';
					            }
					            else
					            {
											//$query_new=mysqli_query($con,"INSERT log_in set username='$username', password='$password', name='$name', email='$email', datejoined = 'CURRENT_TIMESTAMP', patientid='$pid', admin= 0, staff= 0,caregiver=1");
                                            $sql_stmt = "INSERT INTO 'log_in' (username,password,name,email,date_joined,patient_id,admin,staff,caregiver) VALUES ($username, $password,$name,$email,CURRENT_TIMESTAMP,$pid, 0,0,1)";
                                            $query_new=mysqli_query($con, $sql_stmt);
    
                                            if($query_new)
												{
													echo '<script>alert("User Registered.. Welcome");</script>';
												}
												else
												{
													echo '<p class="bg-danger msg-block">Registration Unsuccessful due to server error. Please try later</p>';
												}
											}
										}
										else
										{
											echo '<script type="text/javascript">alert("DB error")</script>';
										}
									}
									else
									{
										echo '<script type="text/javascript">alert("Password and Confirm Password do not match")</script>';
									}
				}
?>
<!DOCTYPE html>
<html>
<head>
<html lang="en">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>Admin | Create Profile</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">
  </head>

  <body>

  <section id="container" >
      <header class="header black-bg">
              <div class="sidebar-toggle-box">
                  <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
              </div>
            <a href="#" class="logo"><b>Admin Dashboard</b></a>
            <div class="nav notify-row" id="top_menu">

                </ul>
            </div>
            <div class="top-menu">
            	<ul class="nav pull-right top-menu">
                    <li><a class="logout" href="logout.php">Logout</a></li>
            	</ul>
            </div>
        </header>
	  <!-- sidebar -->
      <aside>
          <div id="sidebar"  class="nav-collapse ">
              <ul class="sidebar-menu" id="nav-accordion">

              	  <p class="centered"><a href="#"><img src="assets/img/logo100.png" width="125"></a></p>
              
				  
                  <li class="sub-menu">
                      <a href="manage-patients.php" >
                          <i class="fa fa-users"></i>
                          <span>Manage Patients</span>
                      </a>
                  </li>
				  
				   <li class="sub-menu">
                      <a href="manage-staff.php" >
                          <i class="fa fa-users"></i>
                          <span>Manage Staff</span>
                      </a>
                  </li>
				  
				  <li class="sub-menu">
                      <a href="manage-admin.php" >
                          <i class="fa fa-users"></i>
                          <span>Manage Admin</span>
                      </a>
                  </li>

              </ul>
          </div>
      </aside>
	  <?php $ret=mysqli_query($con,"select * from patient where id='".$_GET['uid']."'");
	  $row=mysqli_fetch_array($ret);
	  $patient_id=$row['id'];
	  ?>

      <section id="main-content">
          <section class="wrapper">
          	<h3><i class="fa fa-angle-right"></i> Caregiver Sign Up Form</h3>

		<div class="row">

                  <div class="col-md-12">
                      <div class="content-panel">
                      <p align="center" style="color:#F00;"><?php echo $_SESSION['msg'];?><?php echo $_SESSION['msg']=""; ?></p>
                           <form class="form-horizontal style-form" name="form1" method="post" action="" onSubmit="return valid();">
                           <p style="color:#F00"><?php echo $_SESSION['msg'];?><?php echo $_SESSION['msg']="";?></p>
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">Username</label>
                              <div class="col-sm-10">
                                  <input type="text" placeholder="Enter Username" class="form-control" name="username" required>
                              </div>
                          </div>

                              <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">Email</label>
                              <div class="col-sm-10">
                                  <input type="text" placeholder="Enter Email" class="form-control" name="email" required>
                              </div>
                          </div>

                               <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">Password</label>
                              <div class="col-sm-10">
                                  <input type="password" placeholder="Enter Password" class="form-control" name="password" required>
                              </div>
                          </div>

						  <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">Confirm Password</label>
                              <div class="col-sm-10">
                                  <input type="password" placeholder="Enter Password" class="form-control" name="cpassword" required >
                              </div>
                          </div>
				   <input type="hidden" name="patient_id" value="<?php echo $patient_id?>">


									<div class="form-group">
										<div class="col-sm-10">
                      <div style="margin-left:100px;">
						  <button name="submit" type="submit" class="btn btn-theme">Sign Up</button>
							</div>
										</div>
                          </form>
                      </div>
                  </div>
              </div>
		</section>
      </section></section>

	</div>

</body>
</html>
