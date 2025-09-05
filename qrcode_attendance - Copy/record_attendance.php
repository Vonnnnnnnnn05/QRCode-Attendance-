<?php
include 'conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['student_id'], $_POST['typeofevent'])) {
    $student_id = $_POST['student_id'];
    $status = 'Present';
    $typeofevent = $_POST['typeofevent'];

    // Insert attendance record
    $query = "INSERT INTO attendance (student_id, status, typeofevent) VALUES ('$student_id', '$status', '$typeofevent')";
    
    if (mysqli_query($conn, $query)) {
        echo "Attendance recorded for ID: $student_id";
    } else {
        echo "Error recording attendance.";
    }
}
?>
