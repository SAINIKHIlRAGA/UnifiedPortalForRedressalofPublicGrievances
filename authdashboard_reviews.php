<!DOCTYPE html>
<?php 
    include("auth_sidebar.php");
    include('bootstrap.php');
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
    <h3>Reviews given by users to you</h3>
        <table>
        <tr>
            <th class="cid">Review Id</th>
            <th class="ra">User Name</th>
            <th>Complaint Id</th>
            <th class="rvw">View Review</th>
            <th class="rvw">View Complaint</th>
            <th>Given at</th>
        </tr>
        <?php 
            include('config.php');
            $sql = "SELECT review_id, given_at, review, dept_name, complaint, complaints.complaint_id as 'c_id', user_id, complaints.authority_id as 'authority_id' from complaints join authority_details on complaints.authority_id = authority_details.authority_id join reviews on complaints.complaint_id = reviews.complaint_id join departments on departments.dept_id = complaints.dept_id where complaints.authority_id = '$user_id'";
            $result = $conn->query($sql);
            if($result->num_rows>0)
            {
                while($row = $result->fetch_assoc())
                {
                    $u_id = $row['user_id'];
                    $sql1 = "SELECT concat(firstname, ' ' ,lastname) as 'name' from user_details where user_id = '$u_id'";
                    $result1 = $conn->query($sql1);
                    if($result1->num_rows > 0)
                    {
                        $row1 = $result1->fetch_assoc();
                        $user_name = $row1['name'];
                    }
                    $comp_id = $row['c_id'];
                    $review = $row['review'];
                    $review_id = $row['review_id'];
                    $complaint = $row['complaint'];
                    echo "<tr><td class='cid'>".$row["review_id"]."</td><td class='ra'>".$user_name."</td><td class='ra'>".$row['c_id']."</td><td class='rvw'>"."<button class='btn btn-success' onclick=\"view_review('$review', $comp_id, $review_id)\"><small>View Review</small></button>"."</td><td>"."<button class='btn btn-success' onclick=\"view_complaint('$complaint', $comp_id)\"><small>View Complaint</small></button>"."</td><td class='ra'>".$row['given_at']."</td></tr>";
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