<?php
session_start();
include "config.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM members WHERE email=? OR student_id=? LIMIT 1");
    $stmt->bind_param("ss", $email, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows == 1){
        $user = $result->fetch_assoc();
        if(password_verify($password, $user['password'])){
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];

            if($user['role'] == 'admin'){
                header("Location: ../admin-dashboard.html");
            } else {
                header("Location: ../member-dashboard.html");
            }
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "No user found.";
    }
}
?>