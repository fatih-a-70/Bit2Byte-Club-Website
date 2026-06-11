<?php
include "config.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['content']; // matches form textarea name
    $tags = $_POST['category'];      // matches form input name
    $link = $_POST['link'] ?? '#';    // add link field in form if needed

    $imageName = "";
    if(isset($_FILES['image']) && $_FILES['image']['name'] !== "") {
        $imageName = time() . "_" . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/images/" . $imageName);
    }

    $stmt = $conn->prepare("INSERT INTO projects (title, description, tags, image, link) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $title, $description, $tags, $imageName, $link);

    if($stmt->execute()){
        header("Location: ../projects.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>