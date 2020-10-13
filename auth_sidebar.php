<!DOCTYPE html>
<?php 
    session_start();
    $user_id = $_SESSION['user_id'];
    include('bar.php');
 ?>

<html>
<head>
  <title>AUTHORITY HOME</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body{
    background-image: url("https://wallpapertag.com/wallpaper/full/e/1/0/118962-best-background-gradient-1920x1200-for-tablet.jpg");               
}
.sidenav {
  height: 100%;
  width: 0;
  position: fixed;
  z-index: 1;
  top: 80px;
  left: 0;
  background-color: black;
  overflow-x: hidden;
  transition: 0.5s;
  padding-top: 100px;
}

.sidenav a {
  padding: 8px 8px 8px 32px;
  text-decoration: none;
  font-size: 25px;
  color: white;
  display: block;
  transition: 0.5s;
}

.sidenav a:hover {
  color: gold;
}

.sidenav .closebtn {
  position: absolute;
  top: 0;
  right: 25px;
  font-size: 36px;
  margin-left: 50px;
}

#main {
  margin-top:0px;
  transition: margin-left .5s;
  padding: 16px;
}
.img1{
  width: 100px;
  height: 100px;
  border-radius: 50%;
  position: absolute;
  top: 20px;
  left: calc(50% - 50px);
}
h1{
  font-size: 50px;
  
}
</style>
</head>
<body>

<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <img src="https://www.paceind.com/wp-content/uploads/2016/09/display-14.png" class="img1"><br>
    <a href="authority_main.php" ><i class="fa fa-home fa-fw"></i>DASHBOARD</a><br>
    <a href="edit_nonuser.php" >EDIT PROFILE</a><br>
    <a href="authdashboard_complaintspending.php" >PENDING COMPLAINTS</a><br>
    <a href="authdashboard_complaints.php" >SOLVED COMPLAINTS</a><br>
    <a href="authdashboard_reviews.php" >VIEW REVIEWS</a><br>
    <a href="logout.php"> LOG OUT</a><br>
</div>

<div id="main">
  <span style="font-size:30px;cursor:pointer; font-style: italic;;" onclick="openNav()">&#9776; MENU</span>
</div>

<script>
function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
  document.getElementById("main").style.marginLeft = "0px";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
  document.getElementById("main").style.marginLeft= "0";
}
</script>
   
</body>
</html> 
