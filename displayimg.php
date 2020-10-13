<html>
<?php 
    session_start(); 
    if($_SERVER['REQUEST_METHOD']=='POST')
    {
        $imgsrc = $_POST['imgsrc'];
        // echo "<img src='$imgsrc'>";
    }
?>
</html>