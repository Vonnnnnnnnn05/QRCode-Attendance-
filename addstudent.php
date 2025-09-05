<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student </title>
    <link rel="stylesheet" href="editstudent.css">
</head>
<body>
    <div class="container">
        <form action="addstudentaccount.php" method="POST">
            <h2>Add Student</h2>
        <input type="number" name="studentid" placeholder="Student ID Number">
<input type="text" name="name" placeholder="name">
<input type="text" name="courseyear" placeholder="course and year">

            <button type="submit">Add Student</button>
            <a href="list.php">Back to List Of students</a>
        </form>
    </div>
    
</body>
</html>