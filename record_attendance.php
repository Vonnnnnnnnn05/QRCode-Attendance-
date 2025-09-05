<?php
include 'conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['student_id'], $_POST['typeofevent'], $_POST['status'])) {
    $student_id = $_POST['student_id'];
    $typeofevent = $_POST['typeofevent'];
    $status = $_POST['status']; // "In" or "Out"

    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO attendance (student_id, typeofevent, status, daterecorded) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("sss", $student_id, $typeofevent, $status);

    if ($stmt->execute()) {
        echo "Successfully added attendance for Student ID: " . htmlspecialchars($student_id);
    } else {
        echo "Error recording attendance: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
