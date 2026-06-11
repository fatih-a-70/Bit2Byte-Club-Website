<?php
include "config.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $title = $_POST['title'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $imageName = "";

    if(isset($_FILES['image']) && $_FILES['image']['name'] !== "") {
        $imageName = time() . "_" . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/" . $imageName);
    }

    $stmt = $conn->prepare("INSERT INTO blogs (title, category, description, image) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $title, $category, $description, $imageName);

    if($stmt->execute()){
        header("Location: ../blog.html");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>