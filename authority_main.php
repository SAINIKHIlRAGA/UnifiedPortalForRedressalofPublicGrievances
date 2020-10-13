<html>
<?php 
    include("auth_sidebar.php");
    // include("bootstrap.php");
    $user_id = $_SESSION['user_id'];
    include('config.php');
    $sql2 = "SELECT COUNT(*) from complaints where authority_id='$user_id' and status='solved'";
    $result2 = $conn->query($sql2);
    if($result2->num_rows>0)
        $row2 = $result2->fetch_assoc();
    $solvedcount =  $row2['COUNT(*)'];
    $sql3 = "SELECT COUNT(*) from complaints where authority_id='$user_id' and status!='solved'";
    $result3 = $conn->query($sql3);
    if($result3->num_rows>0)
        $row3 = $result3->fetch_assoc();
    $unsolvedcount =  $row3['COUNT(*)'];
    $sql4 = "SELECT COUNT(review_id) from reviews join complaints on complaints.complaint_id = reviews.complaint_id where authority_id='$user_id'";
    $result4 = $conn->query($sql4);
    if($result4->num_rows>0)
        $row4 = $result4->fetch_assoc();
    $reviewcount =  $row4['COUNT(review_id)'];
    $sql5 = "SELECT dept_name, location from authority_details ad join departments dp on dp.dept_id = ad.dept_id where authority_id = '$user_id'";
    $result5 = $conn->query($sql5);
    if($result5->num_rows>0)
        $row5 = $result5->fetch_assoc();
    
    $dept_name = $row5['dept_name'];
    // $dept_id = $row5['dept_id'];
    $location = $row5['location'];

    $sql6 = "SELECT count(msg_id) from messages ms join complaints cs on ms.complaint_id = cs.complaint_id where authority_id = '$user_id'";
    $result6 = $conn->query($sql6);
    if($result6->num_rows>0)
        $row6 = $result6->fetch_assoc();
    
    $messagecount = $row6['count(msg_id)'];

?>
    <head>
        <title>Authority Dashboard</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <style>
            body{
                background-image: url("https://wallpapertag.com/wallpaper/full/e/1/0/118962-best-background-gradient-1920x1200-for-tablet.jpg");
                /* background-color: lightpink; */
            }
            .sidebar{
                height:100%;
                background-color: black;
                width: 250px;
                position: fixed;
                top: 0;
                left: 0;
                overflow: hidden;
                padding-top: 100px;
            }
            .sidebar a{
                text-decoration: none;
                font-size:25px;
                color:white;
                padding:10px;
                display:block;
            }
            .sidebar a:hover{
                color: gold;
            }
            .main{
                margin-left:500px;
            }
            img{
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
            .main1
            {
                display: flex;
                flex-direction: row;
                position: absolute;
                left : 22%;
                top: 30%;
                background-color: transparent;
                width: 1000px;
                height: 250px;
            }
            .first, .second, .third, .fourth
            {
                text-align: center;
                box-sizing: border-box;
                width: 200px;
                height: 190px;
                margin: 30px;
                padding: 30px;
                border-radius: 20px;
                font-size: 20px;
            }
            .first:hover, .second:hover, .third:hover, .fourth:hover
            {
                width: 220px;
                height:200px;
                padding: 40px;
                transition: 0.2s;
            }
            .first
            {
                background-color: gray;
            }
            .second
            {
                background-color: gold;
            }
            .third
            {
                background-color: lightgreen;
            }
            .fourth
            {
                background-color: cyan;
            }
            a
            {
                text-decoration: none;
            }
        </style>
    </head>
    <body>
        <h2 style="margin-left: 70%;">Location : <?= $location?></h2>
        <h2 style="margin-left: 70%;">Department: <?= $dept_name?></h2>
    <h2 style="margin-left:40%;">Authority Dashboard</h2>
            
        <div style="margin-top: 10%" class="main1">
            <a href='authdashboard_complaints.php'>
                <div class="second">
                    <p>Solved Complaints</p>
                    <p><?php echo $solvedcount; ?></p>
                 </div>
            </a>
            <a href='authdashboard_complaintspending.php'>
                <div class="third">
                    <p>Pending Complaints</p>
                    <p><?php echo $unsolvedcount; ?></p>
                </div>
            </a>
            <a href='authdashboard_reviews.php'>
                <div class="fourth">
                    <p>Review Count</p>
                    <p><?php echo $reviewcount; ?></p>
                </div>
            </a>
            <a href='authdashboard_notifs.php'>
                <div class="fourth">
                    <p>Notifications Count</p>
                    <p><?php echo $messagecount; ?></p>
                </div>
            </a>
        </div>
    </body>
</html>