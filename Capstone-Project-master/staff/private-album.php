<?php
session_start();
include'dbconnection.php';

//ensures user is logged in
if($_SESSION['login']!="1"){
	header( "Location: ../log-in.php");
}

?>

<?php
//get patient name and info from db
    $connect = mysqli_connect("us-cdbr-iron-east-04.cleardb.net", "bc9da719e482f3", "deea7ef6", "heroku_dbefbfd5b04ac35");
    $profile = $_GET['uid'];
    $query = "SELECT * FROM patient WHERE id='$profile'";
    $result = mysqli_query($connect, $query);
    $value = mysqli_fetch_assoc($result);
    $valuefname = $value['fname'];
    $valuelname = $value['lname'];
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>Staff | Private Album</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

  </head>

  <body>
        <section id="container" >
            <header class="header black-bg">
                    <div class="sidebar-toggle-box">
                        <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
                    </div>
                  <a href="#" class="logo"><b>Staff Dashboard</b></a>
                  <div class="nav notify-row" id="top_menu">
                </ul>
            </div>
            <div class="top-menu">
            	<ul class="nav pull-right top-menu">
                    <li><a class="logout" href="#">Logout</a></li>
            	</ul>
            </div>
        </header>

	  <!-- sidebar -->
      <aside>
          <div id="sidebar"  class="nav-collapse ">
              <ul class="sidebar-menu" id="nav-accordion">

              	  <p class="centered"><a href="#"><img src="https://vetstreet-brightspot.s3.amazonaws.com/de/7def60a7fb11e0a0d50050568d634f/file/Rottweiler-5-645mk062811.jpg" width="125"></a></p>

              	 
                    <li class="sub-menu">
                      <a href="#" >
                          <i class="fa fa-users"></i>
                          <span>Manage Patients</span>
                      </a>
                  </li>
                  <li class="sub-menu">
                      <a href="#" >
                          <i class="fa fa-image"></i>
                          <span>Public Album</span>
                      </a>
                  </li>

              </ul>
          </div>
      </aside>
      
      <section id="main-content">
          <section class="wrapper">
          	<h3><i class="fa fa-angle-right"></i> Patient Albums</h3>
				<div class="row">
                  <div class="col-md-12">
                      <div class="content-panel">
                        <h4> Album Collection </h4>
                        <ul class="nav pull-right top-menu">
                        <li><a class="logout" href="#" style="margin-top:-35px";>View Profile</a></li>
                        <li><a class="logout" href="#" style="margin-top:-35px";>Upload Media</a></li>
                        </ul>
                        <br>
                        <br>

                        <div class="card-deck">
                                <div class="col mb-4">
                                  <div class="card h-100 w-100">
                                    <img src="https://os-webapp1.s3.amazonaws.com/2.jpg" class="card-img-top" alt="...">
                                    <div class="card-body">
                                      <h5 class="card-title">Card title</h5>
                                      <p class="card-text"><small class="text-muted">46 Items</small>
                                      <button class="btn btn-danger btn-s pull-right" onClick="return confirm('Do you really want to delete');"  a href="https://www.facebook.com/" >
                                            <i class="fa fa-trash-o " alt="Delete" title="Delete"></i></button></a></p>
                                    </div>
                                  </div>
                                </div>
                                <div class="col mb-4">
                                    <div class="card h-100 w-100">
                                      <img src="$urlstr" id="$urlstr" class="card-img-top" alt="...">
                                      <div class="card-body">
                                        <h5 class="card-title">$item</h5>
                                        <p class="card-text"><small class="text-muted">46 Items</small>
                                        <button class="btn btn-danger btn-s pull-right" onClick="return confirm('Do you really want to delete');"  a href="https://www.facebook.com/" >
                                              <i class="fa fa-trash-o " alt="Delete" title="Delete"></i></button></a></p>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col mb-4">
                                    <div class="card h-100 w-100">
                                      <img src="https://os-webapp1.s3.amazonaws.com/dog.png" class="card-img-top" alt="...">
                                      <div class="card-body">
                                        <h5 class="card-title">Card title</h5>
                                        <p class="card-text"><small class="text-muted">46 Items</small>
                                        <button class="btn btn-danger btn-s pull-right" onClick="return confirm('Do you really want to delete');"  a href="https://www.facebook.com/" >
                                              <i class="fa fa-trash-o " alt="Delete" title="Delete"></i></button></a></p>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col mb-4">
                                    <div class="card h-100 w-100">
                                      <img src="https://os-webapp1.s3.amazonaws.com/dog.png" class="card-img-top" alt="...">
                                      <div class="card-body">
                                        <h5 class="card-title">Card title</h5>
                                        <p class="card-text"><small class="text-muted">46 Items</small>
                                        <button class="btn btn-danger btn-s pull-right" onClick="return confirm('Do you really want to delete');"  a href="https://www.facebook.com/" >
                                              <i class="fa fa-trash-o " alt="Delete" title="Delete"></i></button></a></p>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col mb-4">
                                    <div class="card h-100 w-100">
                                      <img src="https://os-webapp1.s3.amazonaws.com/dog.png" class="card-img-top" alt="...">
                                      <div class="card-body">
                                        <h5 class="card-title">Card title</h5>
                                        <p class="card-text"><small class="text-muted">46 Items</small>
                                        <button class="btn btn-danger btn-s pull-right" onClick="return confirm('Do you really want to delete');"  a href="https://www.facebook.com/" >
                                              <i class="fa fa-trash-o " alt="Delete" title="Delete"></i></button></a></p>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col mb-4">
                                    <div class="card h-70 w-90">
                                      <img src="https://os-webapp1.s3.amazonaws.com/dog.png" class="card-img-top" alt="...">
                                      <div class="card-body">
                                        <h5 class="card-title">Card title</h5>
                                        <p class="card-text"><small class="text-muted">46 Items</small>
                                        <button class="btn btn-danger btn-s pull-right" onClick="return confirm('Do you really want to delete');"  a href="https://www.facebook.com/" >
                                              <i class="fa fa-trash-o " alt="Delete" title="Delete"></i></button></a></p>
                                      </div>
                                    </div>
                                  </div>
                                  


                            </div>

                        </div>

                    </div>
                    </div>
                </div>
            </section>




        <script src="assets/js/jquery.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
        <script src="assets/js/jquery.scrollTo.min.js"></script>
        <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>
        <script src="assets/js/common-scripts.js"></script>
        <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    </body>
</html>
