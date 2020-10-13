<!DOCTYPE html>
<?php 
include("user_sidebar.php");
include("bootstrap.php");
$user_id = $_SESSION['user_id'];?>
<html>
    <head>
        <title>User DashBoard</title>
        <style>
            body
            {
                background-repeat: no-repeat;
                background-size: cover;
            }
            table
            {
                margin-left:0px;
                border-collapse: collapse;
            }
            h3{
                margin-left:250px;
            }
            #a
            {
                margin-top: 30px;
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
        <h3 id='a'>Reviews given by you!!!</h3>
        <table>
        <tr>
            <th>S.No</th>
            <th style="min-width: 50px">Review Id</th>
            <th class="ra">Authority Name</th>
            <th>Complaint Id</th>
            <th>Department</th>
            <th class="rvw">Review</th>
            <th>Complaint</th>
            <th>Given At</th>
            <th>Edit Review</th>
            <th>Delete</th>
        </tr>
        <?php 
        $edit1 = array();
        $edit3 = array();
        $edit5 = array();
        $j=0;
        include('config.php');
                // $sql = "SELECT reviewid, username, authorityname, text FROM reviews";
                $sql = "SELECT review_id, given_at, review, dept_name, complaint, complaints.complaint_id as 'c_id', user_id, complaints.authority_id as 'authority_id' from complaints join authority_details on complaints.authority_id = authority_details.authority_id join reviews on complaints.complaint_id = reviews.complaint_id join departments on departments.dept_id = complaints.dept_id where complaints.user_id = '$user_id'";
                $result = $conn->query($sql);
                if($result->num_rows>0)
                {
                    $i = 1;
                    while($row = $result->fetch_assoc())
                    {
                        $authority_id = $row['authority_id'];
                        $sql2 = "SELECT concat(firstname, ' ', lastname) as 'name' from user_details where user_id = '$authority_id'";
                        $result2 = $conn->query($sql2);
                        if($result2->num_rows > 0)
                        {
                            $row2 = $result2->fetch_assoc();
                            $authority_name = $row2['name'];
                        }

                        $edit1[$j] = $row["review_id"]; 
                        $edit3[$j] = $authority_name;
                        $edit5[$j] = $row["review"];

                        
                        $comp_id = $row['c_id'];
                        $review = $row['review'];
                        $review_id = $row['review_id'];
                        $complaint = $row['complaint'];
                        echo "<tr><td>".$i++."</td><td class='cid'>".$review_id."</td><td class='ra'>".$authority_name."</td><td class='ra'>".$row['c_id']."</td><td class='ra'>".$row['dept_name']."</td><td class='rvw'>"."<button class='btn btn-success' onclick=\"view_review('$review', $comp_id, $review_id)\"><small>View Review</small></button>"."</td><td>"."<button class='btn btn-success' onclick=\"view_complaint('$complaint', $comp_id)\"><small>View Complaint</small></button>"."</td><td class='ra'>".$row['given_at']."</td><td class='opt'>"."<button id='edit' onclick='edited1($edit1[$j],\"$edit3[$j]\",\"$edit5[$j]\", \"$complaint\")'><span class='edit'>EDIT</span><img src='edit-regular.svg'></button></td><td class='opt'><button id='del' onclick='deleted1($edit1[$j])''><span class='del'>DELETE</span><img src='trash-alt-regular.svg'></button></td></tr>";
                        // echo "<tr><td class='cid'>".$row["review_id"]."</td><td class='ra'>".$authority_name."</td><td class='ra'>"."Rating HERE"."</td><td class='rvw'>".$row["text"]."</td><td class='opt'>"."<button id='edit' onclick='edited1($edit1[$j],\"$edit3[$j]\",\"$edit5[$j]\")'><span class='edit'>EDIT</span><img src='edit-regular.svg'></button></td><td class='opt'><button id='del' onclick='deleted1($edit1[$j])''><span class='del'>DELETE</span><img src='trash-alt-regular.svg'></button></td></tr>";
                        $j++;
                    }
                }
            ?>

<div class="modal" id="review-modal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                
                    <!-- Modal Header -->
                    <div class="modal-header">
                    <h4 class="modal-title text-left">
                        <span class="text-left">Review-ID : <span id='review-id'></span></span>
                        
                    </h4>
                    <h4 class="modal-title" style="margin-left: 40%;">
                    <span class="pull-right">Complaint-ID : <span id='complaint-id'></span></span>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    
                    <!-- Modal body -->
                    <div class="modal-body">
                        <p id='review-data'></p>
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


        <button type="button" class="btn" id='review-button' data-toggle="modal" data-target="#review-modal">
        
        <button type="button" class="btn" id='complaint-button' data-toggle="modal" data-target="#complaint-modal">

        <script>
            function view_review(review, cid, rid)
            {
                // alert(comp);
                document.getElementById('review-data').innerHTML = review;
                document.getElementById('complaint-id').innerHTML = cid;
                document.getElementById('review-id').innerHTML = rid;
                document.getElementById('review-button').click();
            }

            function view_complaint(comp, id)
            {
                // alert(comp);
                document.getElementById('complaint-data').innerHTML = comp;
                document.getElementById('comp-id').innerHTML = id;
                document.getElementById('complaint-button').click();
            }

        </script>




            <div id="delete1"></div>
            <script>
            
            function edited1(i,j,k, complaint)
            {
                document.getElementById('delete1').innerHTML = '<form "style=display:none;" method="post" action="editreview.php"><input type="text" id= "reviewid" name="reviewid"><textarea id="complaint" name="complaint"></textarea><input type="text" id="authorityname" name="authorityname"><input type="text" id="text" name="text"><input type="submit" id="sub"></form>';
                document.getElementById('reviewid').value = i;
                document.getElementById('authorityname').value = j;
                document.getElementById('text').value = k;
                document.getElementById('complaint').value = complaint;
                document.getElementById('sub').click(); 
            }
            function deleted1(i)
            {   
                document.getElementById('delete1').innerHTML= '<form "style=display:none;" method="post" action="delete.php"><input type="text" id= "complaintid" name="reviewid"><input type="submit" id="submit" name="submit2"></form>';
                document.getElementById('complaintid').value = i;
                document.getElementById('submit').click();               
            }
        </script>
        </table>
    </body>
</html>