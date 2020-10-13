<?php 
session_start();
    if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        $cid = $_SESSION["cid"];
        $complaint = $_POST["complaint"];
        $image = $_POST["image"];
        include('config.php');
        $sql = "UPDATE complaints SET complaint='$complaint', complaint_file='$image' WHERE complaint_id='$cid'";
        $conn->query($sql);
        header("location: user_pen_complaints.php");
    }
    ?>