<!DOCTYPE html>
<?php include("admin_sidebar.php")?>
<html>
    <head>
        <title>AdminDashBoard</title>
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
    <h3 id='a'>AUTHORITY DETAILS<h3>
        <table>
            <tr>
                <th style="max-width: 5px;">S.No</th>
                <th style="width: 100px;">Authority ID</th>
                <th class="ra" style="min-width:150px;">Name</th>
                <th class="ra" style="min-width: 100px;">Department</th>
                <th>Location</th>
                <th  style="min-width: 120px;">Contact No.</th>
                <th class="rvm">Email ID</th>
            </tr>
        <?php 
            include('config.php');
            $sql = "SELECT user_details.*, dept_name FROM user_details join authority_details on user_details.user_id = authority_details.authority_id join departments on authority_details.dept_id = departments.dept_id where usertype='Authority'";
            $result = $conn->query($sql);
            if($result->num_rows>0)
            {
                $i = 1;
                while($row = $result->fetch_assoc())
                {
                  
                    echo "<tr><td>".$i++."</td><td class='cid'>".$row["user_id"]."</td><td class='ra'>".$row['firstname']." ".$row['lastname']."</td><td class='ra'>".$row['dept_name']."</td><td class='ra'>".$row['location']."</td><td class='ra'>".$row['contact']."</td><td class='rvw'>".$row["email"]."</td></tr>";
                  
                }
            }
            ?>
        </table>
    </body>
</html>