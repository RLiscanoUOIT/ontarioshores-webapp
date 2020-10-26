<?php 
//if($_SESSION['login']!="1"){
//header("Location: stafflogin.php");}

session_start(); 

// function for the list items
// sequence number -> url string -> html list item
function emitCheckboxEntry($seqnumber, $url)
{
    $name = "gallery[]";
    $id = "cb" . $seqnumber;

	$output = "";
	
	$output .= "<li>";
	$output .= "<input type='checkbox' id='".$id."' name='".$name."' value = '".$seqnumber."' />";
	$output .= PHP_EOL;
	$output .= "<label for='".$id."'>";
	$output .= "<img class='gallery' src='".$url."' />";
	$output .= "</label>";
	$output .= "</li>";

	return $output;
}

function emitAlbumSelectorOption($albumname) {
    return "<option value='{$albumname}'>{$albumname}</option>";
}

function mergeStrings($carry, $item) {
    $carry .= PHP_EOL . $item;
    return $carry;
}

// establish and check connection for the nth time
$mysqli = new mysqli("us-cdbr-iron-east-04.cleardb.net", "bc9da719e482f3", "deea7ef6", "heroku_dbefbfd5b04ac35");
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit(-1);
}
// given profileid and album name
$profile = $_GET['profileid'];
$albumname = $_GET['albumname'];

// we want to get the associated image paths from the db
$query = "SELECT id, link FROM new_media WHERE type='picture' AND patientid=? AND album=?";
$stmt = $mysqli->prepare($query);

if($stmt == FALSE) {
    // sql statement broken
    printf("SQL preparation failed\n");
    exit(-2);
}

$stmt->bind_param('is', $profile, $albumname);
$stmt->execute();
$stmt->bind_result($id, $url);

$ids = [];
$urls = [];

$counter = 0;
while($stmt->fetch()) {
    array_push($ids, $id);
    array_push($urls, $url);
}
$stmt->close();

// gallery list presentation
$galleryContents = array_map('emitCheckboxEntry', array_keys($urls), $urls);
$galleryHtml = array_reduce($galleryContents, 'mergeStrings');

// now we want to get the list of available albums
$query = "SELECT DISTINCT album FROM new_media WHERE patientid=? AND album IS NOT NULL AND album <> ''";
$stmt = $mysqli->prepare($query);

if($stmt == FALSE) {
    // sql statement broken
    printf("SQL preparation failed\n");
    exit(-2);
}

$stmt->bind_param('i', $profile);
$stmt->execute();
$stmt->bind_result($album);

$albums = [];
while($stmt->fetch()) {
    array_push($albums, $album);
}
$albumOptionHtml = array_reduce(array_map('emitAlbumSelectorOption', $albums), 'mergeStrings');

$_SESSION['galleryDataID'] = $ids;
$_SESSION['galleryDataURL'] = $urls;


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

   <!-- topbar -->
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
            <div class="top-menu">
            	<ul class="nav pull-right top-menu">
                    <li><a class="logout" href="logout.php" style="margin-top:-35px">Logout</a></li>
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
                      <a href="../pub-album.php" >
                          <i class="fa fa-image"></i>
                          <span>Public Album</span>
                      </a>
                  </li>

              </ul>
          </div>
      </aside>

      <section id="main-content">
          <section class="wrapper">
          	<h3><i class="fa fa-angle-right"></i> <?php echo$albumname?> </h3>

                <form action="secondpage.php" method="post">
            

                <select name='selectedAlbum'>
                <!--https://stackoverflow.com/a/30525521-->
                <option value="" selected disabled hidden>Album to move/copy to</option>
                <?php echo $albumOptionHtml; ?>
                </select>

                <!-- keep the album and profileid to the next page -->
                <!-- https://stackoverflow.com/a/17264124 -->
                <input type="hidden" name="currentAlbum" value="<?php echo $albumname; ?>" />
                <input type="hidden" name="currentProfileID" value="<?php echo $profile; ?>" />

                <input type="submit" name="submitButton" value="Copy" />
                <input type="submit" name="submitButton" value="Move" />
                <input type="submit" name="submitButton" value="Delete" />
                
                <input type="submit" name="submitButton" value="Play From First Selected" /> 
                <br/>
                <ul class="gallery">
                <?php
                    echo $galleryHtml;
                ?>

                </ul>
                <aside>
                </asi de>
                </form>

            </section>
        </section>
    </section>




    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="assets/js/common-scripts.js"></script>
  
</body>
</html>
