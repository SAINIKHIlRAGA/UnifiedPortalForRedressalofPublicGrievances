<!DOCTYPE html>
<html>
<?php 
session_start();

if($_SERVER["REQUEST_METHOD"]=="POST")
{
    $_SESSION["rid"] = $_POST["reviewid"];
    $reviewid = $_POST["reviewid"];
    $authorityname = $_POST["authorityname"];
    $text = $_POST["text"];
    $complaint = $_POST["complaint"];
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
  <form action="saveeditreview.php" method="POST">
    <div class="row">
      <div class="col1">
        <label for="reviewid">Review ID</label>
      </div>
      <div class="col2">
        <input type="text" name="reviewid" value="<?php echo $reviewid; ?>" readonly>
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
        <textarea id="complaint" readonly name="complaint" placeholder="Write something.." style="height:200px"></textarea>
      </div>
    </div>
    <div class="row">
      <div class="col1">
        <label for="subject">Subject</label>
      </div>
      <div class="col2">
        <textarea id="text" name="text" placeholder="Write something.." style="height:200px"></textarea>
      </div>
    </div>
    <div class="row">
      <input type="submit" value="Save">
    </div>
  </form>
</div>
<script>
        document.getElementById('text').value = "<?php echo $text; ?>";
        document.getElementById('complaint').value = "<?= $complaint; ?>";
</script>
</body>
</html>
