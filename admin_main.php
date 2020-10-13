<html>
<?php 
    include("admin_sidebar.php");
    include('config.php');
    $sql1 = "SELECT COUNT(user_id) from user_details where usertype='citizen'";
    $result1 = $conn->query($sql1);
    if($result1->num_rows>0)
        $row1 = $result1->fetch_assoc();
    $usercount =  $row1['COUNT(user_id)'];
    $sql2 = "SELECT COUNT(user_id) from user_details where usertype='authority'";
    $result2 = $conn->query($sql2);
    if($result2->num_rows>0)
        $row2 = $result2->fetch_assoc();
    $authoritycount =  $row2['COUNT(user_id)'];
    $sql3 = "SELECT COUNT(status) from complaints";
    $result3 = $conn->query($sql3);
    if($result3->num_rows>0)
        $row3 = $result3->fetch_assoc();
    $complaintscount =  $row3['COUNT(status)'];
    $sql4 = "SELECT COUNT(user_id) from user_details where usertype='local_admin'";
    $result4 = $conn->query($sql4);
    if($result4->num_rows>0)
        $row4 = $result4->fetch_assoc();
    $localadmincount =  $row4['COUNT(user_id)'];
    
?>
    <head>
        <title>ADMIN DASH</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <style>
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
            .main{
                margin-left:500px;
            }
            a
            {
                text-decoration: none;
            }
        </style>
    </head>
    <body>
        <div class="main">
            <h1>WELCOME&nbsp; &nbsp;ADMIN !!!</h1>
        </div>
        <div class="main1">
            <a href='admin_view_userdetails.php'>
                <div class="first">
                    <p>Number of Users</p>
                    <p><?php echo $usercount; ?></p>
                </div>
            </a>
            <a href='admin_view_auth_details.php'>
                <div class="second">
                    <p>Number of Authorities</p>
                    <p><?php echo $authoritycount; ?></p>
                </div>
            </a>
            <a href='admin_view_localadmin_details.php'>
                <div class="third">
                    <p>Number of Local Admins</p>
                    <p><?php echo $localadmincount; ?></p>
                </div>
            </a>
            <a href='admindashboard_complaints.php'>
                <div class="fourth">
                    <p>Number of Complaints</p>
                    <p><?php echo $complaintscount; ?></p>
                </div>
            </a>
        </div>
    </body>
</html>