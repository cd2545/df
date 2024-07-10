<?php
session_start();

// เชื่อมต่อกับ MySQL
$servername = "localhost";
$username = "root"; // ชื่อผู้ใช้ MySQL
$password = ""; // รหัสผ่าน MySQL
$dbname = "mywebsite";

// สร้างการเชื่อมต่อ
$conn = new mysqli($id, $username, $password, $email);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// รับข้อมูลจากฟอร์ม
$username = $_POST['username'];
$password = $_POST['password'];

// เตรียมคำสั่ง SQL เพื่อค้นหาผู้ใช้ในฐานข้อมูล
$sql = "SELECT * FROM users WHERE username='$username'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    // พบผู้ใช้ ตรวจสอบรหัสผ่าน
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
        // รหัสผ่านถูกต้อง เริ่ม session
        $_SESSION['username'] = $username;
        echo "เข้าสู่ระบบสำเร็จ";
    } else {
        echo "รหัสผ่านไม่ถูกต้อง";
    }
} else {
    echo "ไม่พบผู้ใช้";
}

$conn->close();
?>
