<?php
include "config.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $tags = $_POST['tags'];

    $stmt = $conn->prepare("INSERT INTO projects (title, description, tags) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $title, $description, $tags);

    if($stmt->execute()){
        echo "Project added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>