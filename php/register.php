<?php
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

    if($password !== $confirm_password){
        echo "Passwords do not match.";
        exit;
    }

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $conn->prepare("INSERT INTO users (full_name, student_id, department, batch, email, phone, interest, message, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $name, $student_id, $department, $batch, $email, $phone, $interest, $message, $hashed_password);

    if ($stmt->execute()) {
        header("Location: ../login.html");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>