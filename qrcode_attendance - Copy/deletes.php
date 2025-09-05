<?php
include("conn.php");
$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM studentaccounts WHERE student_id ='$id' ");


?>
<script>
    window.alert("succesfully deleted");
    window.location = 'list.php';
</script>