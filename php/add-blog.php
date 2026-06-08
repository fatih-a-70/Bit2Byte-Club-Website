<?php
include "config.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category = $_POST['category'];

    $stmt = $conn->prepare("INSERT INTO blogs (title, content, category) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $title, $content, $category);

    if($stmt->execute()){
        echo "Blog added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>