<?php
session_start();
include'dbconnection.php';
//Checking session is valid or not
require_once('dbconfig/config.php');
require('vendor/autoload.php');
// this will simply read AWS_ACCESS_KEY_ID and AWS_SECRET_ACCESS_KEY from env vars
//aws php v3
$s3 = new Aws\S3\S3Client([
  'version' => 'latest',
  'region'  => 'ca-canada-1'
]);
$bucket = getenv('S3_BUCKET')?: die('No "S3_BUCKET" config var in found in env!');

//ensures user is logged in
if($_SESSION['login']!="1"){
	header( "Location: log-in.php");
}

// for updating user info
if(isset($_POST['upload']))
{
	
}
?>

<!DOCTYPE html>
  <head>
<html lang="en">
    <meta charset="utf-8">
    <meta name="viewport" content="width-device=width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>Staff | Upload Media</title>
    <link href="admin/assets/css/bootstrap.css" rel="stylesheet">
    <link href="admin/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="admin/assets/css/style.css" rel="stylesheet">
    <link href="admin/assets/css/style-responsive.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

  </head>

  <body>

  <section id="container" >
      <header class="header black-bg">
              <div class="sidebar-toggle-box">
                  <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
              </div>
            <a href="#" class="logo"><b>Therapist Dashboard</b></a>
            <div class="nav notify-row" id="top_menu">



                </ul>
            </div>
	  <!-- logout button -->
            <div class="top-menu">
            	<ul class="nav pull-right top-menu">
                    <li><a class="logout" href="admin/logout.php">Logout</a></li>
            	</ul>
            </div>
        </header>
	  <!-- sidebar -->
      <aside>
          <div id="sidebar"  class="nav-collapse ">
              <ul class="sidebar-menu" id="nav-accordion">

              	  <p class="centered"><a href="#"><img src="admin/assets/img/logo100.png" width="125"></a></p>
              	 
                  <li class="sub-menu">
                      <a href="manage-patients.php" >
                          <i class="fa fa-users"></i>
                          <span>Manage Patients</span>
                      </a>
                  </li>
                  <li class="sub-menu">
                      <a href="staff/public-album.php" >
                          <i class="fa fa-image"></i>
                          <span>Public Album</span>
                      </a>
                  </li>

              </ul>
          </div>
      </aside>

      <section id="main-content">
        <section class="wrapper">
        <div class="row">
          <div class="col-md-12">
              <div class="content-panel">
        <form enctype="multipart/form-data" action="<?=$_SERVER['PHP_SELF']?>" method="POST" style="padding-left:1%; margin-top:-3.5%; padding-bottom:1%"><br><br>
<?php
//ensures file is corrected selected
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['userfile']) && $_FILES['userfile']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['userfile']['tmp_name'])) {
try {
	//uploads file to amazon AWS bucket
$upload = $s3->putObject([
        'Bucket' => $bucket,
        'Key'    => $_FILES['userfile']['name'],
        'Body'   => fopen($_FILES['userfile']['tmp_name'],'rb'),
        'ACL'    => 'public-read'
        ]);
  //$bucket, $_FILES['userfile']['name'], fopen($_FILES['userfile']['tmp_name'], 'rb'), 'public-read');

	//gets input field values and file link to update db
$tmplink = $_FILES['userfile']['name'];
$link = "https://os-webapp1.s3.amazonaws.com/" . $tmplink;
	$album=$_POST['album'];
	$filelink=$_POST['link'];
	$patientid=$_POST['patientid'];
	$tags=$_POST['tags'];
  $type=$_POST['type'];
  $privacy='patient';
	$query=mysqli_query($con,"INSERT new_media SET link='$link', type='$type', patientid='$patientid', album='$album', tags='$tags', privacy='patient'");	
	if($query)
		{
    echo "<script>alert('Media Added');</script>";
    echo $privacy;
		}
	
		header( "Location: staff/manage-patients.php");
?>

<?php } catch(Exception $e) { ?>
<p>Upload error i cri:(</p>
<?php } } ?>
		
<?php
	$ret=mysqli_query($con,"select * from patient where id='".$_GET['uid']."'");	
	$row=mysqli_fetch_array($ret);
	$_SESSION['pid']=$row['id'];
	$tmpid=$row['id'];
?>
<h3><i class="fa fa-angle-right"></i>Upload Media for <?php echo $row['fname']?> <?php echo $row['lname']?></h3>
<p><?php echo $link ?><p>

<label for="album">Album Name:</label>
<input type="text" id="album" name="album"><br><br>
<label for="tags">Tags:</label>
<input type="text" id="tags" name="tags"><br><br>	
 <label for="type">Type:</label><br>
 <input type="radio" id="picture" name="type" value="picture">
  <label for="picture">Picture</label><br>
  <input type="radio" id="video" name="type" value="video">
  <label for="video">Video</label><br>
  <input type="radio" id="audio" name="type" value="audio">
  <label for="audio">Audio</label><br>
<input type="hidden" id="link" name="link" value="<?php echo $link ?>">
<input type="hidden" id="patientid" name="patientid" value="<?php echo $tmpid?>">
  <input name="userfile" type="file"><br><br>
    <input type="submit" name="upload" value="Upload">
</form>
</div></div>
</div>
</section>
      </section></section>


  </body>
</html>
