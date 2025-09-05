<?php
include("conn.php");
$id = $_GET['id'];

$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM studentaccounts WHERE student_id = '$id'" ));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="editstudent.css">

</head>
<body>
   
    <form action="edits.php?id=<?php echo $id;?>" method="POST">
    <h2>Edit Student</h2>
        <input type="text" name="studentid" value="<?php echo $data['student_id']?>">
        <input type="text" name="name" value="<?php  echo $data['name']?>">
        <input type="text" name="courseyear" value="<?php  echo $data['course_section']?>">
        <button type="submit">Update</button>
        <a href="list.php">Back to List Of students</a>
    </form>
    
</body>
</html>