<?php
session_start();
include('config.php');

if (isset($_POST['submit'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];


    if (empty($username) || empty($password)) {
        $_SESSION['err_login'] = "กรุณากรอกอีเมล์และรหัสผ่าน";
        header('location: login.php');
    }
    else {
        
        $select_stmt = $db->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
        $select_stmt->execute(array(':username' => $username, ':password' => $password));
        $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row) {
            $_SESSION['is_logged_in'] = True;
            $_SESSION['user_id'] = $row['user_id'];
            header('location: index.php');
        }
        else {
            $_SESSION['err_login'] = "อีเมล์หรือรหัสผ่านไม่ถูกต้อง";
            header('location: login.php');
        }
    }
   

    

}