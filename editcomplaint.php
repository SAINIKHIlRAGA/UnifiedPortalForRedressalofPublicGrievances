<!DOCTYPE html>
<html>
<?php 
session_start();

if($_SERVER["REQUEST_METHOD"]=="POST")
{
    $_SESSION["cid"] = $_POST["complaintid"];
    $complaintid = $_POST["complaintid"];
    $authorityname = $_POST["authorityname"];
    $complaint = $_POST["complaint"];
    $image = $_POST["image"];
    $status = $_POST["status"];
}
?>
<head>
<style>
* {
  box-sizing: border-box;
}

input[type=text], select, textarea {
  width: 75%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  resize: vertical;
  background-color:#F0F8FF;
}

label {
  padding: 12px 12px 12px 0;
  display: inline-block;
}

input[type=submit] {
  background-color: #4CAF50;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  float: right;
}

input[type=submit]:hover {
  background-color: #45a049;
}

.container {
  border-radius: 5px;
  background-color:#D8BFD8 ;
  padding: 20px;
}

.col1 {
  float: left;
  width: 25%;
  margin-top: 6px;
}

.col2 {
  float: left;
  width: 75%;
  margin-top: 6px;
}
.row:after {
  content: "";
  display: table;
  clear: both;
}

</style>
</head>
<body>
<div class="container">
  <form action="saveedit.php" method="POST">
    <div class="row">
      <div class="col1">
        <label for="complaintid">Complaint ID</label>
      </div>
      <div class="col2">
        <input type="text" name="complaintid" value="<?php echo $complaintid; ?>" readonly>
      </div>
    </div>
    <div class="row">
      <div class="col1">
        <label for="authorityname">Authority Name</label>
      </div>
      <div class="col2">
        <input type="text" name="authorityname" value="<?php echo $authorityname; ?>" readonly>
      </div>
    </div>
    <div class="row">
      <div class="col1">
        <label for="complaint">Complaint</label>
      </div>
      <div class="col2">
        <textarea id="complaint" name="complaint" placeholder="Write something.." style="height:200px"></textarea>
      </div>
    </div>
    <div class="row">
      <div class="col1">
        <label for="image">Image</label>
      </div>
      <div class="col2">
        <img src ="" id="image" height=100 width=200>
      </div>
    </div>
     <div class="row">
     <div class="col1">
        <label for="image">Status</label>
      </div>
      <div class="col2">
        <p><?php echo $status;?></p><br>
      </div> 	
    </div>
    <div class="row">
      <input type="submit" value="Save">
    </div>
  </form>
</div>
<script>
        document.getElementById('complaint').value = "<?php echo $complaint; ?>";
        document.getElementById('image').src = "<?php echo $image; ?>";
</script>
</body>
</html>
