<?php

if($_SESSION['login']!="1"){
header("Location: adminlogin.php");}

$connect = mysqli_connect("us-cdbr-iron-east-04.cleardb.net", "bc9da719e482f3", "deea7ef6", "heroku_dbefbfd5b04ac35");

function picture_query($connect)
{
 $profile = $_GET['profileid'];
 $query = "SELECT * FROM new_media WHERE type='picture' AND tag LIKE '%{$profile}%' ORDER BY id ASC"; 
 $result = mysqli_query($connect, $query);
 return $result;
}

function video_query($connect)
{
 $profile = $_GET['profileid'];
 $query = "SELECT * FROM new_media WHERE type='video' AND tag LIKE '%{$profile}%' ORDER BY id ASC"; 
 $result = mysqli_query($connect, $query);
 return $result;
}

function audio_query($connect)
{
 $profile = $_GET['profileid'];
 $query = "SELECT * FROM new_media WHERE type='music' AND tag LIKE '%{$profile}%' ORDER BY id ASC"; 
 $result = mysqli_query($connect, $query);
 return $result;
}

function make_slide_indicators($connect)
{
 $output = '';
 $count = 0;
 $result = picture_query($connect);
 while($row = mysqli_fetch_array($result))
 {
  if($count == 0)
  {
   $output .= '
   <li data-target="#dynamic_slide_show" data-slide-to="'.$count.'" class="active"></li>
   ';
  }
  else
  {
   $output .= '
   <li data-target="#dynamic_slide_show" data-slide-to="'.$count.'"></li>
   ';
  }
  $count = $count + 1;
 }
 return $output;
}

function make_slides($connect)
{
 $output = '';
 $count = 0;
 $result = picture_query($connect);
 while($row = mysqli_fetch_array($result))
 {
  if($count == 0)
  {
   $output .= '<div class="item active">';
  }
  else
  {
   $output .= '<div class="item">';
  }
  $output .= '
   <img src="'.$row["link"].'" alt="'.$row["id"].'" style="margin:auto;width:800px;height:700px;"/>
   <div class="carousel-caption">
    <h3>'.$row["link"].'</h3>
   </div>
  </div>
  ';
  $count = $count + 1;
 }
 return $output;
}

function make_video($connect)
{
 $output = '';
 $count = 0;
 $result = video_query($connect);
 while($row = mysqli_fetch_array($result))
 {
  if($count == 0)
  {
   $output .= '<div class="item active">';
  }
  else
  {
   $output .= '<div class="item">';
  }
  $output .= '
   <video src="data/'.$row["link"].'" alt="'.$row["id"].'" class="vid" controls/>
   <div class="carousel-caption">
    <h3>'.$row["link"].'</h3>
   </div>
  </div>
  ';
  $count = $count + 1;
 }
 return $output;
}

function make_audio($connect)
{
 $output = '';
 $count = 0;
 $result = audio_query($connect);
 while($row = mysqli_fetch_array($result))
 {
  if($count == 0)
  {
   $output .= '<div class="item active">';
  }
  else
  {
   $output .= '<div class="item">';
  }
  $output .= '
   <audio controls src="data/'.$row["link"].'" alt="'.$row["id"].'" class="vid"/>
   <div class="carousel-caption">
    <h3>'.$row["link"].'</h3>
   </div>
  </div>
  ';
  $count = $count + 1;
 }
 return $output;
}

?>
<!DOCTYPE html>
<html>
 <head>
  <title>Slideshow</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script>
  $(document).ready(function() {
	$(".begin1").click(function(){
		$("#dynamic_slide_show").carousel('cycle');
	});
	$(".pause1").click(function() {
		$("#dynamic_slide_show").carousel('pause');
	});
  });
  $(document).ready(function() {
	$(".begin2").click(function(){
		$("#dynamic_slide_show2").carousel('cycle');
	});
	$(".pause2").click(function() {
		$("#dynamic_slide_show2").carousel('pause');
	});
  });
  $(document).ready(function() {
	$(".begin3").click(function(){
		$("#dynamic_slide_show3").carousel('cycle');
	});
	$(".pause3").click(function() {
		$("#dynamic_slide_show3").carousel('pause');
	});
  });
  </script>
  <style>
	.box{
		width: 70%;
		height: 200px;
		margin:auto;}
	.begin1{
		height: 50px;
		width: 50px;}
	.pause1{
		height: 50px;
		width: 50px;}		
	.begin2{
		height: 50px;
		width: 50px;}
	.pause2{
		height: 50px;
		width: 50px;}
	.begin3{
		height: 50px;
		width: 50px;}
	.pause3{
		height: 50px;
		width: 50px;}
	.control{
		width: 10%;
		margin:auto;}
	.vid{
		display: block;
		margin-left: auto;
		margin-right: auto;
		width: 50%;}
	.links{
		position:absolute;
		top:0;
		right:0;
		padding:5px;}
  </style>
 </head>
 <body  style="background-color:#919191">
	 <div class="links">
        <a href="help4.html" target="_blank"><h3>Help</h3></a>
    </div>
  <br />
  <?php $profile = $_GET['profileid']; ?>
 <div class="box">
     <!--<div class="container">-->
       <h2 align="center">Pictures in Profile: <?php echo ucfirst($profile); ?></h2>
       <br />
       <div id="dynamic_slide_show" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
        <?php echo make_slide_indicators($connect); ?>
        </ol>
    
        <div class="carousel-inner">
         <?php echo make_slides($connect); ?>
        </div>
        <a class="left carousel-control" href="#dynamic_slide_show" data-slide="prev">
         <span class="glyphicon glyphicon-chevron-left"></span>
         <span class="sr-only">Previous</span>
        </a>
    
        <a class="right carousel-control" href="#dynamic_slide_show" data-slide="next">
         <span class="glyphicon glyphicon-chevron-right"></span>
         <span class="sr-only">Next</span>
        </a>
       </div>
       
       <div class="control">
            <br>
            <button type="button" class="begin1" >
            	<span class="glyphicon glyphicon-play" ></span></button>
            <button type="button" class="pause1">
            	<span class="glyphicon glyphicon-pause" ></span></button>
        </div>
        <h3 align="center">Play/Pause to Control Automatic Slideshow</h3>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
   <h2 align="center">Videos in Profile: <?php echo ucfirst($profile); ?></h2>
<br>
<div id="dynamic_slide_show2" class="carousel slide">
	<div class="carousel-inner">
    	<?php echo make_video($connect); ?>
	</div>
    
  		<a class="left carousel-control" href="#dynamic_slide_show2" data-slide="prev">
         <span class="glyphicon glyphicon-chevron-left"></span>
         <span class="sr-only">Previous</span>
        </a>
    
        <a class="right carousel-control" href="#dynamic_slide_show2" data-slide="next">
         <span class="glyphicon glyphicon-chevron-right"></span>
         <span class="sr-only">Next</span>
        </a>
	</div>
	  <div class="control">
        <br>
        <button type="button" class="begin2" >
        	<span class="glyphicon glyphicon-play" ></span></button>
        <button type="button" class="pause2">
        	<span class="glyphicon glyphicon-pause" ></span></button>
    </div>
    <h3 align="center">Play/Pause to Control Automatic Slideshow</h3>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
   <h2 align="center">Music in Profile: <?php echo ucfirst($profile); ?></h2>
<br>
<div id="dynamic_slide_show3" class="carousel slide">
	<div class="carousel-inner">
    	<?php echo make_audio($connect); ?>
	</div>
    
  		<a class="left carousel-control" href="#dynamic_slide_show3" data-slide="prev">
         <span class="glyphicon glyphicon-chevron-left"></span>
         <span class="sr-only">Previous</span>
        </a>
    
        <a class="right carousel-control" href="#dynamic_slide_show3" data-slide="next">
         <span class="glyphicon glyphicon-chevron-right"></span>
         <span class="sr-only">Next</span>
        </a>
    </div>
	 <div class="control">
        <br>
        <button type="button" class="begin3" >
        	<span class="glyphicon glyphicon-play" ></span></button>
        <button type="button" class="pause3">
       		<span class="glyphicon glyphicon-pause" ></span></button>
    </div>
    <h3 align="center">Play/Pause to Control Automatic Slideshow</h3>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
</body>
</html>
