<?php 

//if($_SESSION['login']!="1"){
//header("Location: stafflogin.php");}

//session_start();
//creating a connection
$mysqli = new mysqli("us-cdbr-iron-east-04.cleardb.net", "bc9da719e482f3", "deea7ef6", "heroku_dbefbfd5b04ac35");

//checking connection
if($mysqli->connect_error){
    die("Connection failed: " . $mysqli->connect_error);
}

$currAlbum = $_REQUEST['currentAlbum'];
$currProfile = $_REQUEST['currentProfileID'];


$redirectURL = "/";
$redirectTime = 3;

function checkAlbumSelected($currprof, $curralbm, &$redirurl, &$redirtime) {
    if(!isset($_REQUEST['selectedAlbum'])) {
        $redirurl = "albumgallery.php?profileid={$currprof}&albumname={$curralbm}";
        $redirtime = 5;
        
        echo "<p>No target album was selected. Going back.</p>";
        echo "<br/>";
        echo "<a href='albumgallery.php?profileid={$currProfile}&albumname={$curralbm}'>Click here if the browser is not automatically redirecting in {$redirectTime} seconds.</a>";
    }
}

function transformGalleryID($gallerySelected) {
    return array_map(function($galleryid) {
        return $_SESSION['galleryDataID'][$galleryid];
    }, $gallerySelected);
    
}


function transformGalleryURL($gallerySelected) {
    return array_map(function($galleryid) {
        return $_SESSION['galleryDataURL'][$galleryid];
    }, $gallerySelected);
    
}



if(!isset($_REQUEST['gallery'])) {
    $redirectURL = "albumgallery.php?profileid={$currProfile}&albumname={$currAlbum}";
    $redirectTime = 5;
    echo "<p>No image was selected. Going back.</p>";
    echo "<br/>";
    echo "<a href='albumgallery.php?profileid={$currProfile}&albumname={$currAlbum}'>Click here if the browser is not automatically redirecting in {$redirectTime} seconds.</a>";
} else {

    switch($_REQUEST['submitButton']) {
    case 'Copy':
        checkAlbumSelected($currProfile, $currAlbum, $redirectURL, $redirectTime);
        copyToAlbum($mysqli, $currProfile ,transformGalleryURL($_REQUEST['gallery']), $_REQUEST['selectedAlbum'] );

        $redirectURL = "albumgallery.php?profileid={$currProfile}&albumname={$currAlbum}";
        $redirectTime = 24;
        break;
    case 'Move':
        checkAlbumSelected($currProfile, $currAlbum, $redirectURL, $redirectTime);
        
        moveToAlbum($mysqli, transformGalleryID($_REQUEST['gallery']), $_REQUEST['selectedAlbum']);
        
        $redirectURL = "albumgallery.php?profileid={$currProfile}&albumname={$currAlbum}";
        $redirectTime = 0;
        break;
    case 'Delete':
        deleteFromAlbum($mysqli, transformGalleryID($_REQUEST['gallery']), transformGalleryURL($_REQUEST['gallery']));
        $redirectURL = "albumgallery.php?profileid={$currProfile}&albumname={$currAlbum}";
        $redirectTime = 0;
        break;
    case 'Play From First Selected':
        $firstSelect = transformGalleryID($_REQUEST['gallery'])[0];
        $redirectTime = 0;
        $redirectURL= "profiles.php?profileid={$currProfile}&albumname={$currAlbum}&startpicture={$firstSelect}";
        break;
    }
}

function moveToAlbum($connect, $tableIDs, $album) {

    $query = "UPDATE new_media SET album=? WHERE id=?";
    $stmt = $connect->prepare($query);

    $stmt->bind_param('si', $album, $id);

    foreach($tableIDs as $id) {
        $stmt->execute();
    }
    $stmt->close();

}

function deleteFromAlbum($connect, $tableIDs, $tableURLs) {
    $query = "DELETE FROM new_media WHERE id=?";
    $stmt = $connect->prepare($query);

    $stmt->bind_param('i', $id);

    foreach($tableURLs as $url) {
        unlink($url);
    }

    foreach($tableIDs as $id) {
        $stmt->execute();
    }
    $stmt->close();
    
}

function copyToAlbum($connect, $currProfile, $tableURLs, $album) {
    $query = "INSERT INTO new_media (patientid, type, link, album, tags) VALUES (?, \"picture\", ?, ?, \"\")";
    $stmt = $connect->prepare($query);

    $stmt->bind_param('iss', $currProfile, $newurl, $album);
    
    $newurls = [];
    foreach($tableURLs as $oldurl) {
        $newname = pathinfo($oldurl, PATHINFO_DIRNAME) . "/" . uniqid("copy") . ".". pathinfo($oldurl, PATHINFO_EXTENSION);

        copy($oldurl, $newname);
        array_push($newurls, $newname);
    }

    foreach($newurls as $newurl) {

        print_r($currProfile);
        print_r($newurl);
        print_r($album);
        $stmt->execute();
    }

    $stmt->close();
}

?>

<meta http-equiv="refresh" content="<?php echo $redirectTime; ?>; URL='<?php echo $redirectURL; ?>'"/> 
