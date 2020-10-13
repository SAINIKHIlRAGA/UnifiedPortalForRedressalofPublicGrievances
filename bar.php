<html>
<?php 
if(isset($_SESSION['user_id'])==TRUE)
{
    if($_SESSION['usertype']=='citizen')
    {
      echo '<ul class="ul1"><li class="li1"><a href="user_main.php">Dashboard</a></li>';
    }
    else if($_SESSION['usertype']=='authority')
    {
      echo '<ul class="ul1"><li class="li1"><a href="authority_main.php">Dashboard</a></li>';
    }
    else if($_SESSION['usertype']=='admin')
    {
      echo '<ul class="ul1"><li class="li1"><a href="admin_main.php">Dashboard</a></li>';
    }
    else
    {
      echo '<ul class="ul1"><li class="li1"><a href="local_admin_main.php">Dashboard</a></li>';
    }
}
else
{
  echo '<ul class="ul1"><li class="li1"><a href="main.php">Home</a></li>';
}
  echo '<li class="li1"><a href="about.php">About Us</a></li>';
  if(isset($_SESSION['user_id'])==TRUE)
  {
    echo '<li class="li1"><a href="viewdetailsuser.php">Profile</a></li>';
    echo '<li class="li1"><a href="edituser.php">Edit Profile</a></li>';
    echo '<li class="li1"><a href="logout.php">Logout</a></li></ul>';
  }
  else
  {
    echo '<li class="li1"><a href="login.php">Login</a></li>';
    echo '<li class="li1"><a href="signup.php">Sign Up</a></li>';
    echo '<li class="li1"><a href="complaint.php">Complaint</a></li></ul>';
  }
?>
<style>
.ul1 {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  background-color:DarkOrchid;
  border: 1px solid ghostwhite;
  border-radius: 40px;
}
.li1 {
  position: relative;
  float: left;
  left: 10px;
}
.li1 a {
  display: block;
  color: wheat;
  text-align: center;
  padding-top: 20px;
  padding-left: 100px;
  padding-bottom: 20px;
  padding-right: 100px;
  text-decoration: none;
  font-size: 18px;
  transition: 0.2s;
}
.li1 a:hover:not(.active) {
  background-color: gold;
  color: black;
  transform: scale(1.3);
}
</style>
</html>