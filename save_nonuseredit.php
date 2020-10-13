<?php   
session_start(); 
    $location = $firstname = $lastname = $email = $password = $contact = $usertype ="";
        $firstnameErr = $lastnameErr = $locationErr = $emailErr = $passwordErr = $contactErr = $confirmpasswordErr= "";
        include('config.php');
        $user_id = $_SESSION['user_id'];
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            if(empty($_POST["firstname"]))
            {
                $firstnameErr = "First Name cannot be Empty.";
            }
            else
            {
                if(!preg_match("/^[a-zA-Z ]+$/", $_POST["firstname"]))
                {
                    $firstnameErr = "First Name should contain only alphabets and spaces.";
                }
                else
                {
                    $firstname = $_POST["firstname"];   
                }
            }
            if(empty($_POST["lastname"]))
            {
                $lastnameErr = "Last Name cannot be Empty.";
            }
            else
            {  
                if(!preg_match("/^[a-zA-Z ]+$/", $_POST["lastname"]))
                {
                    $lastnameErr = "Last Name should contain only alphabets and spaces.";
                }
                else
                {
                    $lastname = $_POST["lastname"]; 
                }
            }
            if(empty($_POST["location"]))
            {
                $locationErr = "Location cannot be Empty.";
            }
            else
            {  
                if(!preg_match("/^[a-zA-Z ]+$/", $_POST["location"]))
                {
                    $locationErr = "Location should contain only alphabets and spaces.";
                }
                else
                {
                    $location = $_POST["location"]; 
                }
            }
            if(empty($_POST["contact"]))
            {
                $contactErr = "Contact Number cannot be empty.";
            }
            else
            {
                if(!preg_match("/^\\+?[0-9]{0,2}-?[0-9]{10,15}$/",$_POST["contact"]))
                {
                    $contactErr = "Contact Number Should contain only digits and +, -";
                }
                else
                {
                    $contact = $_POST["contact"];
                }
            }
            if(empty($_POST["email"]))
            {
                $emailErr = "Email cannot be empty.";
            }
            else
            {
                if(!preg_match("/^[a-zA-Z0-9.-_+%]+@[a-zA-Z]{3,8}\.[a-zA-Z-_]{2,5}$/",$_POST["email"]))
                {
                    $emailErr = "Email format is invalid.";
                }
                else
                {
                    $email = $_POST["email"];
                }
            }
            if(empty($_POST["password"]))
            {
                $passwordErr = "Password cannot be empty";
            }
            else
            {
                if(strlen($_POST["password"])<5)
                {
                    $passwordErr = "Password is too short. It should be more than 5 letters.";
                }
                else
                {
                    $password = $_POST["password"];
                }
            }
            $usertype = $_POST['usertype'];
            

            if($locationErr ==''&&$emailErr ==''&&$firstnameErr ==''&&$lastnameErr==''&&$passwordErr==''&&$contactErr=='')
            {
                $sql = "UPDATE user_details SET firstname='$firstname', lastname='$lastname', location='$location', contact='$contact', email='$email', password='$password' WHERE user_id='$user_id'";
                if ($conn->query($sql) == TRUE) {
                    echo "Saved successfully";
                    // echo "<script>alert('Saved Successfully');</script>";
                    header('location: edit_nonuser.php');  
                    
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
            else
            {
                echo $firstnameErr."<br>";
                echo $lastnameErr."<br>";
                echo $locationErr."<br>";
                echo $emailErr."<br>";
                echo $passwordErr."<br>";
                echo $confirmpasswordErr."<br>";
                echo $contactErr."<br>";
            }
        }
        $conn->close();           
           
?>
