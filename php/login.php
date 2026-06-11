<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include "config.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email_or_id = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=? OR student_id=? LIMIT 1");
    $stmt->bind_param("ss", $email_or_id, $email_or_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows == 1){
        $user = $result->fetch_assoc();

        if(password_verify($password, $user['password'])){
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];

            if($user['role'] == 'admin'){
                header("Location: ../admin-dashboard.php");
            } else {
                header("Location: ../member-dashboard.php");
            }
            exit;
        } else {
            echo "<p style='color:red; text-align:center;'>Incorrect password.</p>";
        }
    } else {
        echo "<p style='color:red; text-align:center;'>No user found with that email or student ID.</p>";
    }
}
?>