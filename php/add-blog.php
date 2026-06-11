<?php
include "config.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['content'];
    $category = $_POST['category'];
    $link = $_POST['link'] ?? '#';

    $imageName = "";
    if(isset($_FILES['image']) && $_FILES['image']['name'] !== "") {
        $imageName = time() . "_" . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/images/" . $imageName);
    }

    $stmt = $conn->prepare("INSERT INTO blogs (title, category, description, image, link) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $title, $category, $description, $imageName, $link);

    if($stmt->execute()){
        header("Location: ../blog.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>