<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include "config.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $name = $_POST['name'];
    $student_id = $_POST['student_id'];
    $department = $_POST['department'];
    $batch = $_POST['batch'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $interest = $_POST['interest'];
    $message = $_POST['message'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = 'member'; // default role for new users

    if($password !== $confirm_password){
        echo "Passwords do not match.";
        exit;
    }

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $conn->prepare("INSERT INTO users (full_name, student_id, department, batch, email, phone, interest, message, password, role) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssss", $name, $student_id, $department, $batch, $email, $phone, $interest, $message, $hashed_password, $role);

    if ($stmt->execute()) {
        header("Location: ../login.html");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>