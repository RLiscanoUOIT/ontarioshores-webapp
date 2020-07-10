<?php 
session_start();

if($_SESSION['login']!="1"){
header("Location: caregiverlogin.php");}


//session_start(); 

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
<html>

<head>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <style>
        ul.gallery {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-gap: 10px;
            grid-auto-rows: minmax(100px, auto);
            
            list-style-type: none;
            float: left;
        }
        img.gallery {
            height: 300px;
            width: 300px;
        }
        aside {
            float: right;
        }

        footer {
            position: fixed;
            bottom: 0px;
            width: 100%;
            /*height: 2.5rem;*/
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <div class="w3-top">
        <div class="w3-bar w3-white w3-wide w3-padding w3-card">
            <a href="https://ontario-shores.herokuapp.com/upload.php" class="w3-bar-item w3-button"><b>Manage Patients</b></a>
            <!--Float to the right, hide in small screen -->
            <div class="w3-right w3-hide-small">
                <a href="help3.html" class="w3-bar-item w3-button" target="_blank">Help</a>
            </div>
        </div>
    </div>
    <br>
    <br>
    <br>
    <br>
    <br>

<form action="nextpage.php" method="post">
<ul class="gallery">
<?php
    echo $galleryHtml;
?>
</ul>
<aside>

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
<br />
<input type="submit" name="submitButton" value="Play From First Selected" />
</aside>
</form>

    <!-- Footer -->
    <footer class="w3-center w3-black w3-padding-16">
        <p>Made For <a href="https://www.ontarioshores.ca/" title="Ontario Shores Center for Mental Health Science"
                target="_blank" class="w3-hover-text-green">Ontario Shores Center for Mental Health Sciences</a> in
            collaboration with Ontario Tech University</p>
    </footer>
</body>

</html>
