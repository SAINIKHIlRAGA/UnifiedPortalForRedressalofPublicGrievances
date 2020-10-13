<?php
    include('config.php');
    $complaint_id = $_POST['complaint_id'];
    $msg = $_POST['msg'];

    $sql = "INSERT INTO reviews(complaint_id, review) VALUES($complaint_id, '$msg')";

    $conn->query($sql);
?>