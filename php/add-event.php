<?php
include "config.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $title = $_POST['title'];
    $type = $_POST['type'];
    $description = $_POST['description'];
    $event_date = $_POST['event_date'];
    $imageName = "";

    if(isset($_FILES['image']) && $_FILES['image']['name'] !== "") {
        $imageName = time() . "_" . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/" . $imageName);
    }

    $stmt = $conn->prepare("INSERT INTO events (title, type, description, event_date, image) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $title, $type, $description, $event_date, $imageName);

    if($stmt->execute()){
        header("Location: ../events.html");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>