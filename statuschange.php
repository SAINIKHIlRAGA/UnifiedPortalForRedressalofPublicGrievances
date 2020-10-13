<?php 
    if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        include('config.php');
        $cid = $_POST["cid"];
        $sql = "UPDATE complaints SET status=1 where complaintid=$cid";
        $conn->query($sql);
        header('location:authoritydashboard.php');
    }
?>