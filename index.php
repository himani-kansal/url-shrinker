<?php 

//include database connection details
include 'db.php';
//connect to MYSQL database
$conn= new mysqli($servername,$username,$password,$dbname);

if($conn->connect_error)
{
  die("Connection failed :" .$conn->connect_error);
}

$server_name="http://".$_SERVER['HTTP_HOST']."/";

//redirect to real link if URL is set
if (!empty($_GET['url'])) {
  $query="SELECT url_link FROM urltable WHERE url_short = '".$_GET['url']."'";
  $result=$conn->query($query);
  $row=$result->fetch_assoc();
  if(!empty($row))
  {
	$r = "http://".str_replace("http://","",$row["url_link"]);
	header('HTTP/1.1 301 Moved Permanently');  
	header('Location: '.$r);  
  }
  else
  {
    die("Connection failed :");
  }
}



//insert new url
if (!empty($_POST['url'])) {
//make url short link by shuffling the string
$short = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 3);
$queryInsert ="INSERT INTO urltable (url_link, url_short, url_ip, url_date) VALUES

	(
	'".addslashes($_POST['url'])."',
	'".$short."',
	'".$_SERVER['REMOTE_ADDR']."',
	'".time()."'
	)  ";
$queryInsertResult = $conn->query($queryInsert);
$row = "?s=$short";
header('Location: '.$row); 
die;

}
//

?>

<!DOCTYPE html>
<html>
<head>
      <!--Let browser know website is optimized for mobile-->
<meta name="viewport" content="width=device-width,initial-scale=1.0" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <link href="css/bootstrap.min.css" rel="stylesheet">
<title>Url Shrinker</title>
<style type="text/css">
body,nav
	{
		background: url('bg.jpg');
-webkit-animation: backgroundScroll 20s linear infinite;
animation: backgroundScroll 20s linear infinite;
}

@-webkit-keyframes backgroundScroll {
from {background-position: 0 0;}
to {background-position: -400px 0;}
}

@keyframes backgroundScroll {
from {background-position: 0 0;}
to {background-position: -400px 0;}
}
nav
{
	background-color: blue;
}
</style>
</head>

<body>
<div class="container-fluid">
 <!-- Navbar -->
<nav class="navbar navbar-default">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" style="font-family:'Over There'; color:white;">CHK</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#" style="color:white;">About</a></li>
        <li><a href="#" style="color:white;">Developer</a></li>
      </ul>
    </div>
  </div>
</nav>
     <br /><br /><br />   
<h1 style="text-align:center; color:white;"> URL to shrink: </h1><br /><br />
<div class="row">
<div class="col-md-4"></div>
 <form role="form" id="form1" name="form1" method="post" action="" class="col-md-4 col-sm-12">
  <div class="form-group">
    <label for="url"></label>
    <input type="text" class="form-control" id="url" name="url" id="url" value="http://">
  </div>
  <div class="text-center">
  <button type="submit" name="Submit" class="btn btn-primary">GO</button>
  </div>
  <br />
</form>
</div>
</div>


<!--if form was just posted-->
<?php if (!empty($_GET['s'])) { ?>
<br />
<h2 style="text-align:center; color:white;">Here's the short URL: <a href="<?php echo $server_name; ?><?php echo $_GET['s']; ?>" target="_blank" style="color:   #7bea7b;"><?php echo $server_name; ?><?php echo $_GET['s']; ?></a></h2>
<?php } ?>
<!---->
      <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>

</body>
</html>