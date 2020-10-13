<!DOCTYPE html>
<?php 
    include("auth_sidebar.php");
    include('bootstrap.php');
    include('config.php');

    $sql = "SELECT concat(firstname, lastname) as 'name' from user_details ud join authority_details au on au.local_admin_id = ud.user_id where authority_id = '$user_id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $la_name = $row['name'];
?>
<html>
    <head>
        <title>Authority DashBoard</title>
        <style>
            body
            {
                background-repeat: no-repeat;
                background-size: cover;
            }
            table
            {
                border-collapse: collapse;
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
            }
            tr:hover
            {
                background-color: #FFC0CB;
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
                background: transparent;
                border-radius: 3px;
                color:lightgray;
            }
            img
            {
                width:40px;
                height:18px;
            }
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
            button:hover img
            {
                visibility: hidden;
                width:0px;
                height:0px;
            }
            button
            {
                color: black;
                text-decoration: underline;
            }
        </style>
    </head>
    <body>
    <h3>Notifications received from Local Admin - <?= $la_name ?></h3>
        <table>
        <tr>
            <th class="cid" style="min-width:150px">Notification Id</th>
            <th>Complaint Id</th>
            <th class="rvw">View Notification</th>
            <th class="rvw">View Complaint</th>
            <th>Status</th>
            <th>Complaint Registered At</th>
            <th style="max-width: 100px;">Notification Given at</th>

        </tr>
        <?php 
            include('config.php');
            $sql = "SELECT msg_id, given_at, status, registered_at, msg, dept_name, complaint, complaints.complaint_id as 'c_id', user_id, complaints.authority_id as 'authority_id' from complaints join authority_details on complaints.authority_id = authority_details.authority_id join messages on complaints.complaint_id = messages.complaint_id join departments on departments.dept_id = complaints.dept_id where complaints.authority_id = '$user_id'";
            $result = $conn->query($sql);
            if($result->num_rows>0)
            {
                while($row = $result->fetch_assoc())
                {
                    $u_id = $row['user_id'];
                    $status = $row['status'];
                    $comp_id = $row['c_id'];
                    $msg = $row['msg'];
                    $msg_id = $row['msg_id'];
                    $complaint = $row['complaint'];
                    echo "<tr><td class='cid'>".$row["msg_id"]."</td><td class='ra'>".$row['c_id']."</td><td class='rvw'>"."<button class='btn btn-success' onclick=\"view_message('$msg', $comp_id, $msg_id)\"><small>View Notification</small></button>"."</td><td>"."<button class='btn btn-success' onclick=\"view_complaint('$complaint', $comp_id)\"><small>View Complaint</small></button>"."</td><td class='cid2'>"."<button class='btn btn-warning' onclick=\"view_status('$status', $comp_id)\"><small>View Status</small></button>"."</td><td class='ra'>".$row['registered_at']."</td><td class='ra'>".$row['given_at']."</td></tr>";
                }
            }
            ?>
        </table>

        <div class="modal" id="message-modal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                
                    <!-- Modal Header -->
                    <div class="modal-header">
                    <h4 class="modal-title text-left">
                        <span class="text-left">Notification-ID : <span id='message-id'></span></span>
                        
                    </h4>
                    <h4 class="modal-title" style="margin-left: 40%;">
                    <span class="pull-right">Complaint-ID : <span id='complaint-id'></span></span>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    
                    <!-- Modal body -->
                    <div class="modal-body">
                        <p id='message-data'></p>
                    </div>
                    
                    <!-- Modal footer -->
                    <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                    
                </div>
            </div>
        </div>


        
        <div class="modal" id="complaint-modal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                
                    <!-- Modal Header -->
                    <div class="modal-header">
                    <h4 class="modal-title">Complaint-ID : <span id='comp-id'></span></h4>
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




        <button type="button" class="btn" id='message-button' data-toggle="modal" data-target="#message-modal">
        
        <button type="button" class="btn" id='complaint-button' data-toggle="modal" data-target="#complaint-modal">

        <button type="button" class="btn" id='status-button' data-toggle="modal" data-target="#status-modal"></button>

        <script>
            function view_message(msg, cid, mid)
            {
                // alert(comp);
                document.getElementById('message-data').innerHTML = msg;
                document.getElementById('complaint-id').innerHTML = cid;
                document.getElementById('message-id').innerHTML = mid;
                document.getElementById('message-button').click();
            }

            function view_complaint(comp, id)
            {
                // alert(comp);
                document.getElementById('complaint-data').innerHTML = comp;
                document.getElementById('comp-id').innerHTML = id;
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