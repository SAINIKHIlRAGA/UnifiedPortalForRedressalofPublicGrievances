<html>
<?php 
    session_start();
    include "bar.php"; 
    include "bootstrap.php";
    include "config.php";
    $user_id = $_SESSION['user_id'];
    // echo $user_id;
?>
<head>
        <title>
            ADD Complaint
        </title>
    </head>
    
<body>
<div class="container" style="width: 50%;">
  <h2 class="mt-4 text-center">Register Complaint</h2>
  <form enctype="multipart/form-data" action="<?php print $_SERVER['PHP_SELF']?>" method="post">
    <div class="form-group">
        <label for="select1">Location</label>
        <select class="form-control" id="select1" name="location">
            <?php 
                $sql = "SELECT distinct(location) as 'loc' from user_details where usertype != 'admin'";
                $result = $conn->query($sql);
                if($result->num_rows > 0)
                {
                    while($row = $result->fetch_assoc())
                    {
                        $location = $row['loc'];
                        echo "<option value = '$location'>$location</option>";
                    }
                }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="select2">Department</label>
        <select class="form-control" id="select2" name="department">
            <?php 
                $sql = "SELECT dept_name from departments";
                $result = $conn->query($sql);
                if($result->num_rows > 0)
                {
                    while($row = $result->fetch_assoc())
                    {
                        $department = $row['dept_name'];
                        echo "<option value = '$department'>$department</option>";
                    }
                }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="complaint">Complaint:</label>
        <textarea class="form-control" rows="5" id="complaint" name = "complaint" required></textarea>
    </div>
    <div class="form-group">
        <div class="custom-file">
            <input type="file" class="custom-file-input" name="fileToUpload" id="fileToUpload" accept="image/*">
            <label class="custom-file-label" for="customFile">Choose file</label>
        </div>
    </div>
    <div class="form-group text-center">
        <button type="submit" class="btn btn-primary">Register</button>
    </div>
  </form>
</div>

<script>
// Add the following code if you want the name of the file appear on select
$(".custom-file-input").on("change", function() {
  var fileName = $(this).val().split("\\").pop();
  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});
</script>

<?php
    if($_SERVER['REQUEST_METHOD']  == 'POST')
    {
        $target_dir = "images/Complaints/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
            
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
        }

        // Check if file already exists
        if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        $complaint = $_POST['complaint'];
        echo "<script>document.getElementById('complaint').innerHTML = '$complaint';</script>";
        // if everything is ok, try to upload file
        } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            // echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
        
            $location = $_POST['location'];
            $department = $_POST['department'];
            $complaint = $_POST['complaint'];
            $complaint_file = $target_file;
            
            $sql1 = "SELECT dept_id from departments where dept_name = '$department'";
            $result1 = $conn->query($sql1);
            $row1 = $result1->fetch_assoc();
            $dept_id = $row1['dept_id'];
            $authority_id = 'heyy';

            $sql2 = "SELECT authority_id from authority_details where dept_id = $dept_id and location = '$location'";
            $result2 = $conn->query($sql2);
            if($result2->num_rows > 0)
            {
                $i = 1;
                $min = 2147483647;
                $min_auth_id = '';
                while($row2 = $result2->fetch_assoc())
                {   
                    $authority_id = $row2['authority_id'];
                    $sql3 = "SELECT count(*) from complaints where authority_id = '$authority_id'";
                    $result3 = $conn->query($sql3);
                    $row3 = $result3->fetch_assoc();
                    $count = $row3['count(*)'];
                    if($min > $count)
                    {
                        $min = $count;
                        $min_auth_id = $authority_id;
                    }
                    // echo $i++." -> ".$row2['authority_id']." :   ".$count."<br> "; 
                }
            }
            // echo "Assigning case to ".$min_auth_id." as he has ".$min." cases<br>";
            $sql = "INSERT INTO complaints(user_id, authority_id, complaint, location, dept_id, complaint_file) 
            VALUES('$user_id',' $min_auth_id', '$complaint', '$location', $dept_id, '$complaint_file')";

            $conn->query($sql);
            echo "<script>alert('Complaint Registered Successfully');</script>";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
        }
    }
   
   
?>

</body>
</html>
