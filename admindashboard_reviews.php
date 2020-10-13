<!DOCTYPE html>
<?php 
    include("admin_sidebar.php");
    include('bootstrap.php');
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
                margin-left:250px;
                border-collapse: collapse;
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
        </style>
    </head>
    <body>
        <h3 id='a'>Reviews given by users</h3>
        <table>
        <tr>
            <th>S.No</th>
            <th class="cid" style="max-width:10px;">RID</th>
            <th class="ra" style="max-width:30px;">CID</th>
            <th class="ra">Department</th>
            <th>Location</th>   
            <th class="ra" style="min-width:150px;">User Name</th>
            <th class="ra" style="min-width:150px;">Authority Name</th>
            <th class="rvw" style="min-width:120px;">Review</th>
            <th style="min-width: 200px;">Complaint</th>
            <th class="ra">Given At</th>
        </tr>
        <?php 
        include('config.php');
        $sql4 = "SELECT review_id, given_at, review, dept_name, location, complaint, complaints.complaint_id, user_id, complaints.authority_id as 'authority_id' from complaints join reviews on complaints.complaint_id = reviews.complaint_id join departments on departments.dept_id = complaints.dept_id";
        $result4 = $conn->query($sql4);
        if($result4->num_rows > 0)
        {
            $i = 1;
            while($row = $result4->fetch_assoc())
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
                
                $sql2 = "SELECT concat(firstname,' ', lastname) as 'name' from user_details where user_id = '$authority_id'";
                $result2 = $conn->query($sql2);
                if($result2->num_rows > 0)
                {
                    $row2 = $result2->fetch_assoc();
                    $authority_name = $row2['name'];
                }
                $comp_id = $row['complaint_id'];
                $review = $row['review'];
                $review_id = $row['review_id'];
                
                $complaint = $row['complaint'];
                echo "<tr><td>".$i++."</td><td class='cid'>".$row["review_id"]."</td><td class='ra'>".$row['complaint_id']."</td><td class='ra'>".$row['dept_name']."</td><td class='ra'>".$row['location']."</td><td class='ra'>".$user_name."</td><td class='ra'>".$authority_name."</td><td class='rvw'>"."<button class='btn btn-success' onclick=\"view_review('$review', $comp_id, $review_id)\"><small>View Review</small></button>"."</td><td>"."<button class='btn btn-success' onclick=\"view_complaint('$complaint', $comp_id)\"><small>View Complaint</small></button>"."</td><td>".$row['given_at']."</td></tr>";
            }
        }

            ?>
        </table>


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
    </body>
</html>
