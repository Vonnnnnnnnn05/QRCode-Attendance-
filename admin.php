<?php
require 'conn.php'; // Database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Attendance System</title>
    
    <link rel="stylesheet" href="admin.css">
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
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

    <div class="flex-container">
        <!-- Scanner Section -->
        <div class="scanner">
            <div id="reader" style="width: 100%;"></div>
            <p id="result" style="text-align: center; margin-top: 10px;"></p>
            
            <!-- Event Selection Form -->
            <form id="attendanceForm" action="record_attendance.php" method="POST">
                <label for="eventSelect">Select Event:</label>
                <select name="typeofevent" id="eventSelect" required>
                    <option value="">Select Event</option>
                    <option value="Class Attendance">Class Attendance</option>
                    <option value="Intrams">Intrams</option>
                    <option value="Escapade">Escapade</option>
                    <option value="Event">Event</option>
                </select>

                <!-- Status Selection -->
                <label for="status">Status:</label>
                <select name="status" id="status" required>
                    <option value="">Select Status</option>
                    <option value="In">In</option>
                    <option value="Out">Out</option>
                </select>
                
                <!-- Input for Physical Scanner -->
                <label for="student_id">Student ID (Physical Scanner):</label>
                <input type="text" id="student_id" name="student_id">
            </form>
        </div>

        <!-- Attendance Table Section -->
        <div class="main">
            <h2>Attendance Records</h2>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Type of Event</th>
                        <th>Status</th>
                        <th>Date Recorded</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "
                        SELECT sa.name, a.typeofevent, a.status, a.daterecorded
                        FROM attendance a
                        JOIN studentaccounts sa ON a.student_id = sa.student_id
                        ORDER BY a.daterecorded DESC
                    ";
                    $result = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                        $formattedDate = date("F j, Y - h:i A", strtotime($row['daterecorded']));
                        echo "<tr>
                            <td>{$row['name']}</td>
                            <td>{$row['typeofevent']}</td>
                            <td>{$row['status']}</td>
                            <td>{$formattedDate}</td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        const html5QrCode = new Html5Qrcode("reader");

        function onScanSuccess(decodedText, decodedResult) {
            document.getElementById("result").innerText = `Scanned: ${decodedText}`;
            html5QrCode.stop(); // stop after one scan

            const eventType = document.getElementById('eventSelect').value;
            const status = document.getElementById('status').value;
            const studentId = decodedText || document.getElementById('student_id').value;

            if (!eventType) {
                alert("Please select an event.");
                return;
            }

            if (!status) {
                alert("Please select a status (In/Out).");
                return;
            }

            if (!studentId) {
                alert("Please scan or manually enter a student ID.");
                return;
            }

            fetch("record_attendance.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `student_id=${encodeURIComponent(studentId)}&typeofevent=${encodeURIComponent(eventType)}&status=${encodeURIComponent(status)}`
            })
            .then(response => response.text())
            .then(data => {
                alert(data);
                location.reload(); // refresh table
            })
            .catch(error => console.error("Error:", error));
        }

        Html5Qrcode.getCameras().then(devices => {
            if (devices && devices.length) {
                html5QrCode.start(
                    { facingMode: "environment" }, 
                    { fps: 10, qrbox: 250 },
                    onScanSuccess
                );
            }
        });
    </script>

</body>
</html>
