<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    addUser($_POST['email']);
}
function addUser($email){
    $con = mysqli_connect('localhost',"root","blargHblargh1");
    mysqli_query($con, "USE miniWeebly");
    mysqli_query($con, "INSERT INTO auth (email, api_token) VALUES ('" . $email . "', '" . md5(uniqid($email, true)) . "')");
    
    $result = mysqli_query($con, "SELECT * FROM auth WHERE email = '" . $email . "'");
    $row = mysqli_fetch_array($result);
    echo $row['api_token'];
    
    mysqli_close($con);
}
?>