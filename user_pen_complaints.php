<!DOCTYPE html>
<html>
<?php include "user_sidebar.php"; 
include("bootstrap.php");
$user_id = $_SESSION['user_id'];?>
    <head>
        <title>UserDashBoard</title>
        <style>
            body
            {
                background-repeat: no-repeat;
                background-size: cover;
            }
            table
            {
                /* margin-left:150px; */
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
                width:60px;
            }
            .rvw
            {
                width:550px;
            }
            .ra
            {
                width:400px;
            }
            tr
            {
                background-color: aquamarine;
                border: 0;
                border: 2px solid white;
                margin-left:100px;
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
            button .edit
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
            button:hover
            {
                visibility: visible;
                color: red;
                font-size:14px;
            }
            button:hover #img1
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
            h3{
                margin-left:150px;
            }
        </style>
    </head>
    <body>
        <h3>Pending Complaints</h3>
        <table>
        <tr>
                <th>S.No</th>
                <th class="cid">Complaint ID</th>
                <th>Authority Name</th>
                <th>Authority Details</th>
                <th>Department</th>
                <th style='min-width: 150px'>Complaint</th>
                <th>Complaint File</th>
                <th>Registered At</th>
                <th class="cid">Status</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            <?php 
               
               
                include('config.php');
                $sql = "SELECT complaint_id, authority_id, complaint, complaint_file, dept_name, registered_at, status FROM complaints cp join departments dp on cp.dept_id = dp.dept_id where user_id = '$user_id' and status!='solved'";
                $result = $conn->query($sql);
                if($result->num_rows>0)
                {
                    $i = 1;
                    while($row = $result->fetch_assoc())
                    {
                        $authority_id = $row['authority_id'];
                        $sql2 = "SELECT concat(firstname,' ', lastname) as 'name', email, contact from user_details where user_id = '$authority_id'";
                        $result2 = $conn->query($sql2);
                        if($result2->num_rows > 0)
                        {
                            $row2 = $result2->fetch_assoc();
                            $authority_name = $row2['name'];
                            $authority_contact = $row2['contact'];
                            $authority_email = $row2['email'];
                        }
                        $href = 'view_img.php?img='.$row['complaint_file'];

                        

                        $complaint = $row['complaint'];
                        $comp_id = $row['complaint_id'];
                        // echo $complaint."<br>";
                        $status = $row['status'];
                        $complaint_file = $row['complaint_file'];
                        echo "<tr><td>".$i++."</td><td class='cid2'>".$row["complaint_id"]."</td><td>".$authority_name."</td><td>"."<button class='btn btn-success' onclick=\"view_authority_details($comp_id, '$authority_name', '$authority_contact', '$authority_email')\"><small>View Details</small></button>"."</td><td>".$row['dept_name']."</td><td>"."<button class='btn btn-success' onclick=\"view_complaint('$complaint', $comp_id)\"><small>View Complaint</small></button>"."</td><td>"."<button onclick='' ><a href='$href' target='_blank'>View File</a></button>"."</td><td class='cid2'>".$row['registered_at']."</td><td class='cid2'>"."<button class='btn btn-warning' onclick=\"view_status('$status', $comp_id)\"><small>View Status</small></button>"."</td><td class='opt'>"."<button id='edit' onclick='edited($comp_id,\"$authority_name\",\"$complaint\",\"$complaint_file\",\"$status\")'><span class='edit'>EDIT</span><img id='img1' src='edit-regular.svg'></button></td><td><button onclick='deleted($comp_id, \"$status\")''><img src='trash-alt-regular.svg'></button></td></tr>";
                        // echo "<tr><td>".$q++."</td><td class='cid'>".$row["complaintid"]."</td><td>".$row['authorityname']."</td><td>".$row['msg']."</td><td>"."<button onclick='img(\"$edit6[$i]\")'>View Image</button>"."</td><td class='cid' id='status'>".$row['status']."</td><td class='opt'>"."<button id='edit' onclick='edited($edit[$i],\"$edit2[$i]\",\"$edit4[$i]\",\"$edit6[$i]\",$edit8[$i])'><span class='edit'>EDIT</span><img src='edit-regular.svg'></button></td><td class='opt'><button id='del' onclick='deleted($edit[$i])''><span class='del'>DELETE</span><img src='trash-alt-regular.svg'></button></td></tr>";
                    
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

        

        <div class="modal" id="auth-details-modal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                
                    <!-- Modal Header -->
                    <div class="modal-header">
                    <h4 class="modal-title">Complaint-ID : <span id='comp-id'></span></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    
                    <!-- Modal body -->
                    <div class="modal-body text-center font-weight-bold">
                        Authority Name : <span id='auth-name'></span><br>
                        Contact: <span id='auth-contact'></span><br>
                        Email: <span id='auth-email'></span><br>
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


    <button type="button" class="btn" id='complaint-button' data-toggle="modal" data-target="#complaint-modal"></button>
        
    <button type="button" class="btn" id='status-button' data-toggle="modal" data-target="#status-modal"></button>
        
            
    <button type="button" class="btn" id='auth-details-button' data-toggle="modal" data-target="#auth-details-modal"></button>
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

        function view_authority_details(cid, name, contact, email)
        {
            document.getElementById('comp-id').innerHTML = cid;
            document.getElementById('auth-name').innerHTML = name;
            document.getElementById('auth-contact').innerHTML = contact;
            document.getElementById('auth-email').innerHTML = email;

            document.getElementById('auth-details-button').click();
        }
        </script>




        <div id="delete1"></div>
        <script>
            function edited(i,j,k,l,m)
            {   
                document.getElementById('delete1').innerHTML= '<form "style=display:none;" method="post" action="editcomplaint.php"><input type="text" id= "complaintid" name="complaintid"><input type="text" id="authorityname" name="authorityname"><input type="text" name="complaint" id="complaint"><input type="text" id="image" name="image" ><input type="status" id="status" name="status"><input type="submit" id="submit"></form>';
                document.getElementById('complaintid').value = i;
                document.getElementById('authorityname').value = j;
                document.getElementById('complaint').value = k;
                document.getElementById('image').value = l;
                document.getElementById('status').value = m;
                document.getElementById('submit').click();   
 
                            
            }
            
            function deleted(cid, status)
            {   
                alert(status);
                if(status != 'registered')
                {
                    alert('Authority has already starting working on the complaint. In order to terminate the complaint, please contact authority');
                }
                else
                {
                    document.getElementById('delete1').innerHTML= '<form "style=display:none;" method="post" action="delete.php"><input type="text" id= "complaintid" name="complaintid"><input type="submit" id="submit1" name="submit1"></form>';
                    cument.getElementById('complaintid').value = cid;
                    document.getElementById('submit1').click();   
                }         
            }
        </script>
    </body>
</html>