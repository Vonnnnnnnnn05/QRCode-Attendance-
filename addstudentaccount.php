<?php
include("conn.php");

$studentid = $_POST['studentid'];
$name = $_POST['name'];
$course = $_POST['courseyear'];

mysqli_query($conn, "INSERT INTO studentaccounts(student_id, name, course_section) VALUES ('$studentid','$name','$course')");    


?>
<script>
    window.alert("Student Added Successfully");
    window.location = 'list.php';
</script>