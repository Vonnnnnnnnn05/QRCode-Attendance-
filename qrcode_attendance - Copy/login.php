<?php
include("conn.php");

$email = $_POST['email'];
$password = $_POST['password'];

$data = mysqli_query($conn, "SELECT * FROM admin WHERE email='$email' AND password='$password'");

if (!$data) {
    // Show error message if the query fails
    die("Query failed: " . mysqli_error($conn));
}

if (mysqli_num_rows($data) > 0) {
    echo "<script>
        alert('Successfully Logged in');
        window.location = 'admin.php';
    </script>";
} else {
    echo "<script>
        alert('Invalid email or password.');
        window.location = 'index.php';
    </script>";
}
?>
