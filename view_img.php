<?php 
    include('bootstrap.php');
    $src = $_GET['img'];
    // echo $src."<br>";
    if(strpos($src, 'img') !== false){
        echo "<img src='$src'  alternate='$src'>";
    }
    else
    {
        echo "<embed src='$src' type='application/pdf' width='100%' height='600px' />";
    }
?>

