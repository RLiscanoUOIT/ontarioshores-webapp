<?php
if($_SESSION['login']!="1"){
header("Location: adminlogin.php");}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Capstone Project</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  form{
	width: 500px;
	margin:0 auto;
  }
  <style>
  .grid-container {
      display: grid;
      grid-template-columns: 20% 20% 20% 20% 20%;
    }
  </style>
</head>

<body>
  <!-- Navbar -->
  <div class="w3-top" >
    <div class="w3-bar w3-white w3-wide w3-padding w3-card">
<a href="https://ontario-shores.herokuapp.com/admin/manage-patients.php" class="w3-bar-item w3-button"><b>Manage Patients</b></a>        <!--Float to the right, hide in small screen -->
        <div class="w3-right w3-hide-small">
        	<a href="help2.html" class="w3-bar-item w3-button" target="_blank">Help</a>
        </div>
    </div>
  </div><br>
<br>
<br>
<br>
<br>
<br>


  <!--Page-->
  <div class="w3-content w3-padding" style="max-width:1564px">

<!--Project Section -->

<!--Patient Albums -->

<?php
  $connect = mysqli_connect("us-cdbr-iron-east-04.cleardb.net", "bc9da719e482f3", "deea7ef6", "heroku_dbefbfd5b04ac35");
  $profile = $_GET['profileid'];
  $query = "SELECT fname FROM patient WHERE id='$profile'";
  $result = mysqli_query($connect, $query);
  $value = mysqli_fetch_assoc($result);
  $valuestr = $value['fname'];

  $query = "SELECT DISTINCT album FROM new_media WHERE patientid='$profile'";
  $result = mysqli_query($connect, $query);
  $value = mysqli_fetch_assoc($result);
  $album = "";
  if (isset($_GET['albumname'])) {
    $album = $_GET['albumname'];
  }
?>

<div class="w3-container w3-padding-32" id="projects">
  <h3 class="w3-border-bottom w3-border-light-grey w3-padding-16">Select the albums to delete:</h3>
</div>

<form method="post" onsubmit="return confirm('All images in the selected albums will be DELETED, are you sure you wish to continue?');" action="<?php
    $counter = 1;
    foreach ($value as $albumname) {
      if (isset($_POST['submit'])) {
        if (!empty($_POST['check'])) {
          foreach ($_POST['check'] as $key) {
            $query = "DELETE FROM new_media WHERE patientid='$profile' AND album='$key'";
            $delete = mysqli_query($connect, $query);
          }
        }
      }
      $counter+=1;
    }
  ?>">
  <input type="hidden" name="profileid" value="<?php echo $profile ?>"/>
  <div class="grid-container">
    <?php

    $sql = "SELECT DISTINCT album FROM new_media WHERE patientid='$profile' AND type='picture'";
    $result2 = mysqli_query($connect, $sql);
    $opt = "";
    $counter = 1;

      while($row = mysqli_fetch_assoc($result2)) {

        $item = $row['album'];

        $query = "SELECT link FROM new_media WHERE patientid='$profile' AND album='$item' LIMIT 1";
        $img = mysqli_query($connect, $query);
        $url = mysqli_fetch_assoc($img);
        $urlstr = $url['link'];

        $opt .= "<div class='grid-item'><input id='$urlstr' type='checkbox' name='check[]' value='$item'><h5>$item</h5><img src='$urlstr' style='width: 100%; height: 100%; padding: 3px;'></div>";

        $opt .= "<input type='hidden' name='albumname' value='$item'/>";
        $counter+=1;
      }
    ?>

    <?php echo $opt ?>
  </div>
  <button type="submit" name="submit" class="w3-button w3-right w3-red">Delete Albums</button>
</form>
<button class="w3-button w3-right w3-light-grey" onclick="location.href='albumadmin.php?uid=<?php echo $profile ?>'">Cancel</button>

<br>
<br>
<br>
<br>



      <!-- End page content -->
      </div>


      <!-- Footer -->
      <footer class="w3-center w3-black w3-padding-16">
        <p>Made For <a href="https://www.ontarioshores.ca/" title="Ontario Shores Center for Mental Health Science" target="_blank" class="w3-hover-text-green">Ontario Shores Center for Mental Health Sciences</a> in collaboration with Ontario Tech University</p>
      </footer>
</body>
</html>
