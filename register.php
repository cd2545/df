<?php
// ตรวจสอบว่ามีข้อมูลถูกส่งมาจากฟอร์มหรือไม่
if (isset($_POST['username'], $_POST['password'], $_POST['email'])) {
    // รับข้อมูลจากฟอร์ม
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // เข้ารหัสรหัสผ่าน
    $email = $_POST['email'];
    
    // เชื่อมต่อกับ MySQL
    $servername = "localhost";
    $usernameDB = "root"; // ชื่อผู้ใช้ MySQL
    $passwordDB = ""; // รหัสผ่าน MySQL
    $dbname = "mywebsite";

    // สร้างการเชื่อมต่อ
    $conn = new mysqli($servername, $usernameDB, $passwordDB, $dbname);

    // ตรวจสอบการเชื่อมต่อ
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // เตรียมคำสั่ง SQL เพื่อเพิ่มข้อมูลลงในฐานข้อมูล
    $sql = "INSERT INTO users (username, password, email) VALUES ('$username', '$password', '$email')";

    if ($conn->query($sql) === TRUE) {
        echo "ลงทะเบียนสำเร็จ";
    } else {
        if ($conn->errno == 1062) {
            echo "Error: ชื่อผู้ใช้นี้มีอยู่แล้วในระบบ";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
} else {
    echo "กรุณากรอกข้อมูลให้ครบทุกช่อง";
}

?>