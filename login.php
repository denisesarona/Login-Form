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

//def
$login_status = "";
$message = "";

//check if form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    //get form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    //SQL query to finish
    $sql = "SELECT * FROM regform WHERE email='$email'";

    //execute query

    $result = $conn->query($sql);

    if($result->num_rows > 0){
        //user founnd verify pass
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];
        if(password_hash($password, $hashed_password)){
            //password matches, set login
            $login_status="success";
            $message="Welcome $email";
        } else {
            //password not match
            $login_status ="error";
            $message = "Invalid email or password";
        } 
    } else{
        //user not found
        $echo="error";
        $message = "Invalid email";
    }

}

//close connection
$conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN FORM</title>
</head>
<body>
    <?php
    //display
    if($login_status === "success"){
        echo '<script>alert("Welcome '.htmlspecialchars($email).'");</script>';
        echo '<script>window.location.href = "index.html";</script>';
    }elseif($login_status === "error"){
        echo '<script>alert("Invalid email or password");</script>';
        echo '<script>window.location.href = "index.html";</script>';
    }else{
        echo '<script>alert("Form submission failed");</script>';
    }

    ?>
</body>
</html>