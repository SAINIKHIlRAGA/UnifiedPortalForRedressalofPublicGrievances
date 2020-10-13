<!DOCTYPE html>
<?php 
    include("local_admin_sidebar.php");
    include('config.php');
    $sql3 = "SELECT location from user_details where user_id = '$user_id'";
    $result3 = $conn->query($sql3);
    if($result3->num_rows>0)
        $row3 = $result3->fetch_assoc();
    $location =  $row3['location'];
?>
<html>
    <head>
        <title>LocalAdminDashBoard</title>
        <style>
            body
            {
                background-repeat: no-repeat;
                background-size: cover;
            }
            table
            {
                margin-left:30px;
                border-collapse: collapse;
                margin-right:30px;
            }
            h3{
                margin-left:250px;
            }
            #a
            {
                margin-top: 100px;
            }
            td,th
            {
                padding: 10px;   
                width: 280px;
                text-align: center;
                font-size: 16px;
            }
            .cid
            {
                width:90px;
            }
            .rvw
            {
                width:900px;
            }
            .ra
            {
                width:300px;
            }
            tr
            {
                background-color: aquamarine;
                border: 0;
                border: 2px solid white;
                margin-left:100px;
            }
            th
            {
                background-color: lawngreen;
            }
            .opt
            {
                width: 100px;
            }

        </style>
    </head>
    <body>
        <h3 id='a'>USER DETAILS<h3>
        <table>
            <tr>
                <th>S.No</th>
                <th class="cid">User ID</i></th>
                <th style="min-width: 100px">First Name</th>
                <th>Last Name</th>
                <th style="width: 1500px;">Contact No.</th>
                <th class="rvm">Email ID</th>
                <th class="rvm">Address Proof</th>
            </tr>
        <?php 
         
            $sql = "SELECT * FROM user_details where usertype='citizen' and location='$location'";
            $result = $conn->query($sql);
            if($result->num_rows>0)
            {
                $i = 1;
                while($row = $result->fetch_assoc())
                {
                    $href = 'view_img.php?img='.$row['address_proof'];
                    echo "<tr><td>".$i++."</td><td class='cid'>".$row["user_id"]."</td><td class='ra'>".$row['firstname']." ".$row['lastname']."</td><td class='ra'>".$row['location']."</td><td class='ra'>".$row['contact']."</td><td class='rvw'>".$row["email"]."</td><td class='rvw'>"."<a href='$href' target='_blank'>Click Here</a>"."</td></tr>";
   
                }
            }
            ?>
        </table>
    </body>
</html>