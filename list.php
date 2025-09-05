<?php
require 'vendor/autoload.php';
include 'conn.php';

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;

// Create a folder for QR codes if it doesn't exist
if (!is_dir('qrcodes')) {
    mkdir('qrcodes', 0777, true);
}

// Fetch student details from the database
$data = mysqli_query($conn, "SELECT * FROM studentaccounts");
while ($display = mysqli_fetch_array($data)) {
    $studentId = $display['student_id'];
    
    // Create and configure the QR Code
    $qrCode = new QrCode($studentId);
    $qrCode->setSize(300);
    $qrCode->setMargin(10);
    $qrCode->setEncoding(new Encoding('UTF-8')); // Fixed: Using Encoding object
    
    // Generate QR code
    $writer = new PngWriter();
    $result = $writer->write($qrCode);
    
    // Save QR code image
    $qrCodePath = "qrcodes/{$studentId}.png";
    $result->saveToFile($qrCodePath);
    
    // Optional: Force immediate write to disk
    clearstatcache(true, $qrCodePath);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Attendance System</title>
    <link rel="stylesheet" href="list.css">
</head>
<body>

    <nav class="navbar">
        <a href="#" class="brand">QR Code Attendance System</a>
        <ul class="navbar-menu">
            <li><a href="admin.php">Home</a></li>
            <li><a href="list.php">List of Students</a></li>
        </ul>
        <a href="index.php" class="logout" onclick="return confirm('Do you want to logout?')">Logout</a>

    </nav>
    
    <div class="addstudent">
        <a href="addstudent.php"> Add Student</a>
    </div>

    <div class="main"> 
        <table>
            <tr>
                <th>QR Code</th>
                <th>Student ID</th>
                <th>Name</th>
                <th>Course & Section</th>
                <th>Action</th>
            </tr>
            <tbody>
                <?php
                // Display student data with QR codes
                $data = mysqli_query($conn, "SELECT * FROM studentaccounts");
                while ($display = mysqli_fetch_array($data)) {
                    $studentId = $display['student_id'];
                    $qrCodePath = "qrcodes/{$studentId}.png";
                    
                    // Verify QR code exists or generate it on the fly
                    if (!file_exists($qrCodePath)) {
                        $qrCode = new QrCode($studentId);
                        $qrCode->setSize(300);
                        $qrCode->setMargin(10);
                        $qrCode->setEncoding(new Encoding('UTF-8')); // Fixed here too
                        $result = (new PngWriter())->write($qrCode);
                        $result->saveToFile($qrCodePath);
                    }
                ?>
                <tr>
                    <td><img src="<?php echo $qrCodePath; ?>?t=<?php echo time(); ?>" alt="QR Code" width="100"></td>
                    <td><?php echo htmlspecialchars($display['student_id']); ?></td>
                    <td><?php echo htmlspecialchars($display['name']); ?></td>
                    <td><?php echo htmlspecialchars($display['course_section']); ?></td>
                    <td>
                        <a href="editstudent.php?id=<?php echo $display['student_id']; ?>" class="btn-btn success">Edit</a>
                        <a href="deletes.php?id=<?php echo $display['student_id']; ?>" class="btn-btn danger" onclick="return confirm('Are you sure you want to delete this student?')">Delete</a>

                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</body>
</html>