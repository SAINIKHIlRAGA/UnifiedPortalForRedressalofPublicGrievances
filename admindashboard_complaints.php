<!DOCTYPE html>
<?php
    include("admin_sidebar.php");
    include('config.php');
    include('bootstrap.php');
?>
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
                margin-left:250px;
                border-collapse: collapse;
            }
            #a
            {
                margin-top: 100px;
            }
            h3{
                margin-left:250px;
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
            button
            {
                outline: none;
                border:0;
                background: aquamarine;
                border-radius: 3px;
                color:lightgray;
            }
            /* img
            {
                width:40px;
                height:18px;
            } */
            button .edit, .del
            {
                text-align: center;
                visibility: hidden;
                font-size:0;
                
            }
            button:hover .edit
            {
                visibility: visible;
                color: blue;
                font-size:14px;
            }
            button:hover .del
            {
                visibility: visible;
                color: red;
                font-size:14px;
            }
            /* button:hover img
            {
                visibility: hidden;
                width:0px;
                height:0px;
            } */

            #registered
            {
                background-color: #FFFF00;
                color:black;
            }
            #authority
            {
                background-color: aqua;
                color:black;
            }
            #solved
            {
                background-color: green;
                color:black;
            }
        </style>
    </head>
    <body>
        <h3 id='a'>Pending Complaints</h3>
        <table>
            <tr>
                <th>S.No</th>
                <th style="max-width: 10px;">CID</th>
                <th style="min-width: 120px;">User Name</th>
                <th>Authority Name</th>
                <th>Department</th>
                <th>Location</th>
                <th style="min-width: 150px;">Complaint</th>
                <th>Complaint File</th>
                <th style="min-width: 50px;">Registered At</th>
                <th style="min-width: 150px;">Status</th>
            </tr>
            <?php 
                
               
                $sql = "SELECT complaint_id, location, dept_name, user_id, authority_id, complaint, complaint_file, registered_at, status FROM complaints join departments on complaints.dept_id = departments.dept_id where status !='solved'";
                $result = $conn->query($sql);
                if($result->num_rows>0)
                {
                    $i = 1;
                    while($row = $result->fetch_assoc())
                    {
                        $u_id = $row['user_id'];
                        $authority_id = $row['authority_id'];
                        $sql1 = "SELECT concat(firstname, ' ' ,lastname) as 'name' from user_details where user_id = '$u_id'";
                        $result1 = $conn->query($sql1);
                        if($result1->num_rows > 0)
                        {
                            $row1 = $result1->fetch_assoc();
                            $user_name = $row1['name'];
                        }
                        
                        $sql2 = "SELECT concat(firstname, lastname) as 'name' from user_details where user_id = '$authority_id'";
                        $result2 = $conn->query($sql2);
                        if($result2->num_rows > 0)
                        {
                            $row2 = $result2->fetch_assoc();
                            $authority_name = $row2['name'];
                        }
                        $href = 'view_img.php?img='.$row['complaint_file'];
                        $complaint = $row['complaint'];
                        $comp_id = $row['complaint_id'];
                        // echo $complaint."<br>";
                        $status = $row['status'];
                        echo "<tr><td>".$i++."</td><td class='cid2'>".$row["complaint_id"]."</td><td>".$user_name."</td><td>".$authority_name."</td><td>".$row['dept_name']."</td><td>".$row['location']."</td><td>"."<button class='btn btn-success' onclick=\"view_complaint('$complaint', $comp_id)\"><small>View Complaint</small></button>"."</td><td>"."<button onclick='' ><a href='$href' target='_blank'>View File</a></button>"."</td><td class='cid2'>".$row['registered_at']."</td><td class='cid2'>"."<button class='btn btn-warning' onclick=\"view_status('$status', $comp_id)\"><small>View Status</small></button>"."</td></tr>";
                    }
                }
            ?>
        </table>
        <br><br>
        <div class="modal" id="complaint-modal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                
                    <!-- Modal Header -->
                    <div class="modal-header">
                    <h4 class="modal-title">Complaint-ID : <span id='complaint-id'></span></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    
                    <!-- Modal body -->
                    <div class="modal-body">
                        <p id='complaint-data'></p>
                    </div>
                    
                    <!-- Modal footer -->
                    <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                    
                </div>
            </div>
        </div>

        

  <!-- The Modal -->
    <div class="modal" id="status-modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            
                <!-- Modal Header -->
                <div class="modal-header">
                <h4 class="modal-title">Complaint ID : <span id='c-id'></span></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="progress" style="height: 25px;">
                        <div class="progress-bar progress-bar-warning" role="progressbar" id='registered' style="width:30%;">
                            Regsitered
                        </div>
                        <div class="progress-bar progress-bar-info" role="progressbar" id='dot' style="width:1px; background-color: red;">
                           
                        </div>
                        <div class="progress-bar progress-bar-info" role="progressbar" id='authority' style="width:30%;">
                            Authority working on it
                        </div>
                        <div class="progress-bar progress-bar-info" role="progressbar" id='dot' style="width:1px; background-color: red;">
                           
                        </div>
                        <div class="progress-bar progress-bar-success" role="progressbar" id='solved' style="width:40%;">
                            Solved
                        </div>
                    </div>
                </div>
                
                <!-- Modal footer -->
                <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
                
            </div>
        </div>
    </div>

   




        <h3 id='a'>Solved Complaints</h3>
        <table>
            <tr>
                <th>S.No</th>
                <th style="max-width: 10px;">CID</th>
                <th style="min-width: 120px;">User Name</th>
                <th>Authority Name</th>
                <th>Department</th>
                <th>Location</th>
                <th style="min-width: 150px;">Complaint</th>
                <th>Complaint File</th>
                <th style="min-width: 50px;">Registered At</th>
                <th style="min-width: 150px;">Status</th>
            </tr>
            <?php 
                
               
                $sql = "SELECT complaint_id, location, dept_name, user_id, authority_id, complaint, complaint_file, registered_at, status FROM complaints join departments on complaints.dept_id = departments.dept_id where status ='solved'";
                $result = $conn->query($sql);
                if($result->num_rows>0)
                {
                    $i = 1;
                    while($row = $result->fetch_assoc())
                    {
                        $u_id = $row['user_id'];
                        $authority_id = $row['authority_id'];
                        $sql1 = "SELECT concat(firstname, ' ' ,lastname) as 'name' from user_details where user_id = '$u_id'";
                        $result1 = $conn->query($sql1);
                        if($result1->num_rows > 0)
                        {
                            $row1 = $result1->fetch_assoc();
                            $user_name = $row1['name'];
                        }
                        
                        $sql2 = "SELECT concat(firstname, lastname) as 'name' from user_details where user_id = '$authority_id'";
                        $result2 = $conn->query($sql2);
                        if($result2->num_rows > 0)
                        {
                            $row2 = $result2->fetch_assoc();
                            $authority_name = $row2['name'];
                        }
                        $href = 'view_img.php?img='.$row['complaint_file'];
                        $complaint = $row['complaint'];
                        $comp_id = $row['complaint_id'];
                        // echo $complaint."<br>";
                        $status = $row['status'];
                        echo "<tr><td>".$i++."</td><td class='cid2'>".$row["complaint_id"]."</td><td>".$user_name."</td><td>".$authority_name."</td><td>".$row['dept_name']."</td><td>".$row['location']."</td><td>"."<button class='btn btn-success' onclick=\"view_complaint('$complaint', $comp_id)\"><small>View Complaint</small></button>"."</td><td>"."<button onclick='' ><a href='$href' target='_blank'>View File</a></button>"."</td><td class='cid2'>".$row['registered_at']."</td><td class='cid2'>"."<button class='btn btn-warning' onclick=\"view_status('$status', $comp_id)\"><small>View Status</small></button>"."</td></tr>";
                    }
                }
            ?>
        </table>
        <br><br>
        
        
        <button type="button" class="btn" id='complaint-button' data-toggle="modal" data-target="#complaint-modal">
        
        <button type="button" class="btn" id='status-button' data-toggle="modal" data-target="#status-modal"></button>
        
        <script>
        function view_complaint(comp, id)
        {
            // alert(comp);
            document.getElementById('complaint-data').innerHTML = comp;
            document.getElementById('complaint-id').innerHTML = id;
            document.getElementById('complaint-button').click();
        }

        function view_status(status, id)
        {
            // alert(status);
            document.getElementById('c-id').innerHTML = id;
            if(status == 'registered')
            {
                document.getElementById("authority").style.backgroundColor = '#B8B8B8';
                document.getElementById("solved").style.backgroundColor = '#B8B8B8';
            }
            else if(status == 'taken_up_by_authority')
            {
                document.getElementById("authority").style.backgroundColor = 'aqua';
                document.getElementById("solved").style.backgroundColor = '#B8B8B8';
            }
            document.getElementById('status-button').click();
        }
        </script>
    </body>
</html>