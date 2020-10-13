<?php 
    include('config.php');
    $complaintid;
    $reviewid;
    if(isset($_POST['submit1']))
    {
        $complaintid = $_POST['complaintid'];
        
        include('config.php');
        $sql = "DELETE FROM complaints where complaint_id=$complaintid";
        $conn->query($sql);
        header("location:user_pen_complaints.php");
    }
    if(isset($_POST['submit2']))
    {
        $reviewid = $_POST['reviewid'];
        $sql = "DELETE FROM reviews where review_id=$reviewid";
        $conn->query($sql);
        header("location:user_reviews.php");
    }
   
?>