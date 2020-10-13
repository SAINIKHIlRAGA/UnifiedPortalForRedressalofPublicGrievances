<?php
    $comp_id = $_POST['comp_id'];
    $status = $_POST['status'];

    include('config.php');

    $sql = "UPDATE complaints SET status = '$status' WHERE complaint_id = $comp_id";
    $conn->query($sql);


?>