<?php
session_start();
include'dbconnection.php';

//ensuring user is logged in
if($_SESSION['login']!="1"){
	header( "Location: adminlogin.php");
}
// for deleting user
	if(isset($_GET['id']))
	{
	$userid=$_GET['id'];
	$msg=mysqli_query($con,"delete from staff where id='$userid'");
		if($msg)
		{
		echo "<script>alert('Staff data deleted');</script>";
		header( "Location: manage-staff.php");
		}
	}

?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>Admin | Manage Staff</title>
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
      <section id="main-content">
          <section class="wrapper">
          	<h3><i class="fa fa-angle-right"></i> Manage Staff</h3>
				<div class="row">



                  <div class="col-md-12">
                      <div class="content-panel">
                          <table class="table table-striped table-advance table-hover">
	                  	  	  <h4><i class="fa fa-angle-right"></i> All Staff Details </h4>
							  <ul class="nav pull-right top-menu">
                    <li><a class="logout" href="new-staff.php" style="margin-top:-35px";>Add Staff</a></li>
            	</ul>
							  
	                  	  	  <hr>
                              <thead>
                              <tr>
                                  <th></th>
                                  <th class="hidden-phone">Username</th>
                                  <th>Email</th>            
                              </tr>
                              </thead>
                              <tbody>
                              <?php 
				      //searchs db for all staff users
				      $ret=mysqli_query($con,"select * from staff");
							  $cnt=1;
				      //loops through every result
							  while($row=mysqli_fetch_array($ret))
							  {?>
                              <tr>
                              <td><?php echo $cnt;?></td>
                                  <td><?php echo $row['name'];?></td>
                                 <td><?php echo $row['email'];?></td>
                                  <td>
					  <!-- side icons -->
                                     <a href="manage-staff.php?id=<?php echo $row['id'];?>">
                                     <button class="btn btn-danger btn-xs" onClick="return confirm('Do you really want to delete');"><i class="fa fa-trash-o " title="Delete"></i></button></a>
                                  </td>
                              </tr>
                              <?php $cnt=$cnt+1; }?>

                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
		</section>
      </section
  ></section>
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="assets/js/common-scripts.js"></script>
  <script>
      $(function(){
          $('select.styled').customSelect();
      });

  </script>

  </body>
</html>
