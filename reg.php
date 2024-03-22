<?php

$servername = "localhost";
$username= "root";
$password = "";
$dbname = "activity";

//Create Connection
$conn= new mysqli($servername, $username, $password, $dbname);

//CHECK CONNECTION
if($conn->connect_error){
    die("Connection failed " .$conn->connect_error);
}

//check if form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    //get form data
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $currentPass = $_POST['currentpw'];

    //check if pass and connnnfirm pass
    if ($password !== $currentPass){
        //display
        echo '<script> alert("Password and Confirm Password do not match");</script';
    } else{
        $email_check_sql = "SELECT * FROM regform WHERE email='$email'";
        $email_check_sql = $conn->query($email_check_sql);

        if($email_check_sql->num_rows > 0){
            //display error message
            echo '<script>alert("Email already exists");</script';
            echo '<script>window.location.href = "Login.html";</script>';//back to loginphp

        }else{
            //encyrpt pass
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            //SQL
            $sql ="INSERT INTO regform(email,username,pw) VALUES ('$email', '$username' ,'$hashed_password')";

            //execute query
            if($conn->query($sql) === TRUE){
                //display success message
                echo '<script>alert("New record created successfully");</script>';
                echo '<script>window.location.href = "login.html";</script>';//redirect to login
            }else{
                //display error message
                echo '<script>alert("Error: '. $sql. '\n' . $conn->error. '");</script>';
                echo '<script>window.location.href ="login.html";</script>';//redorect to login
            }
        }
    }
    
}
$conn->close();
?>