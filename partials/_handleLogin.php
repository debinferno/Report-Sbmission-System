<?php
$showError = "false";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    include '_dbconnect.php';
    $email = $_POST['loginEmail'];
    $pass = $_POST['loginPass'];

    $sql = "Select * from users where user_email='$email'";
    $result = mysqli_query($conn, $sql);
    $numRows = mysqli_num_rows($result);
    if($numRows==1){
        while ($row = mysqli_fetch_assoc($result)){
            if(password_verify($pass, $row['user_pass'])){
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['sno'] = $row['sno'];
                $_SESSION['useremail'] = $email;
                $_SESSION['username'] = $row[ 'username'];
                $sno=$row['sno'];
                $access=$row['access'];
                header("Location: /tatasteel/welcome.php?loginsuccess=true&sno=$sno&access=$access");
                exit(); 
            }
            else{
                $showError = "Invalid Credentials";
            }
        }
        
    } 
    else{
        $showError = "Invalid Credentials";
    }
    header("Location: /tatasteel/index.php?loginsuccess=false&error=$showError");

}
?>