<?php session_start();
    include('bar.php');
?>
<!DOCTYPE html>
<head>
    <title>Login</title>
<link rel="stylesheet" type="text/css" href="logincss1111.css">
</head>

<body>
    <div class="log"> 
        <img src="https://www.paceind.com/wp-content/uploads/2016/09/display-14.png">
       
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
            <input type="email" placeholder="Email" name="email"><br>
            <input type="password" placeholder="Password" name="password"><br>
            <input class="sub" type="submit" value="Login">
        </form>
        <a href="signup.php">Not a User? Sign Up here</a>
    </div>
    <?php
        include("config.php");        

        if($_SERVER["REQUEST_METHOD"]=="POST")
        {
            include("config.php");

            $email=$_POST['email'];
            $mypassword=$_POST['password'];
            $sql = "SELECT user_id, email, concat(firstname, ' ', lastname) as user_name,  password, usertype FROM user_details WHERE email='$email'";
            $result = $conn->query($sql);
            if($result->num_rows>0)
            {
                while($row = $result->fetch_assoc()) {
                    if($row["password"]==$mypassword && $row["email"]==$email)
                    {
                        $usertype = $row['usertype'];
                        $user_id = $row['user_id'];
                        $_SESSION['user_id']=$user_id;
                        $_SESSION['usertype']=$usertype;
                        $_SESSION['user_name'] = $row['user_name'];
                        if($usertype=='citizen')
                            header("location:user_main.php");
                        else if($usertype=='admin')
                            header("location:admin_main.php");
                        else if($usertype=='local_admin')
                            header("location:local_admin_main.php");
                        else if($usertype=='authority')
                            header("location:authority_main.php");
                    }
                    else
                    {
                        echo "INVALID CREDITIANTIALS!!!<br>  TRY AGAIN!!!";
                        echo "Email: ".$row['email'];
                    }
                        
                }
            }
            else
            {
                echo "INVALID CREDITIANTIALS!!!<br>  TRY AGAIN!!!";
                echo "Email: ".$_POST['email'];
            }
            $conn->close();
        }
           
    ?>
</body>