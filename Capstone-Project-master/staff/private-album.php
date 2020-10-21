<?php
session_start();
include'dbconnection.php';

//ensures user is logged in
if($_SESSION['login']!="1"){
	header( "Location: log-in.php");
}

?>

//get patient name and info from db
<?php
    $connect = mysqli_connect("us-cdbr-iron-east-04.cleardb.net", "bc9da719e482f3", "deea7ef6", "heroku_dbefbfd5b04ac35");
    $profile = $_GET['uid'];
    $query = "SELECT fname FROM patient WHERE id='$profile'";
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
                      <a href="public-album.php" >
                          <i class="fa fa-images"></i>
                          <span>Public Albums</span>
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
                          <table class="table table-striped table-advance table-hover">
	                  	  	  <h4> <?php echo ucfirst($valuelname). " ". ucfirst($valuelname). "'s "; ?> Album Collection </h4>
							  <ul class="nav pull-right top-menu">
                    <li><a class="logout" href="new-patient.php" style="margin-top:-35px";>Upload Media</a></li>
            	              </ul>
                          </table>
                          
                            <div class="w3-container w3-padding-32" id="projects">
                                <button onclick="location.href='albumdeletestaff.php?profileid=<?php echo $profile ?>'" class="w3-button w3-right w3-red">Delete Albums</button>
                            </div>
                            <div class="grid-container">
                            <?php

                            $sql = "SELECT DISTINCT album FROM new_media WHERE patientid='$profile' AND type='picture'";
                            $result2 = mysqli_query($connect, $sql);
                            $opt = "";

                                while($row = mysqli_fetch_assoc($result2)) {

                                $item = $row['album'];

                                $query = "SELECT link FROM new_media WHERE patientid='$profile' AND album='$item' LIMIT 1";
                                $img = mysqli_query($connect, $query);
                                $url = mysqli_fetch_assoc($img);
                                $urlstr = $url['link'];

                                $opt .= "<div class='grid-item'><h5>$item</h5><a href='albumgallery.php?profileid=$profile&albumname=$item'><img id='$urlstr' src='$urlstr' style='width: 100%; height: 100%; padding: 3px;'></a></div>";
                                }
                            ?>

                            <?php echo $opt ?>

                            </div>
                            
              
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
