<?php
include "config.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $tags = $_POST['tags'];
    $imageName = "";

    if(isset($_FILES['image']) && $_FILES['image']['name'] !== "") {
        $imageName = time() . "_" . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/" . $imageName);
    }

    $stmt = $conn->prepare("INSERT INTO projects (title, description, tags, image) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $title, $description, $tags, $imageName);

    if($stmt->execute()){
        header("Location: ../projects.html");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>