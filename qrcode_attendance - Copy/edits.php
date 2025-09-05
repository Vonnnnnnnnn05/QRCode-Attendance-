<?php
include("conn.php");
$id = $_GET['id'];

$studentid = $_POST['studentid'];
$name = $_POST['name'];
$course = $_POST['courseyear'];

mysqli_query($conn, "UPDATE studentaccounts set student_id = '$studentid', name = '$name',course_section = '$course' WHERE student_id = '$id'");


?>
<script>
    window.alert("Succeffully Updated Student");
    window.location = 'list.php';
</script>