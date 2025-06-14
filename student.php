<?php
//Database connection
$host = "localhost";
$user = "root";
$password = "";
$dbname = "school";

$dsn = "mysql:host=$host;dbname=$dbname";

try {
    $conn = new PDO($dsn, $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected to the database successfully.<br><br>";
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

//INSERT a new attendance record
$student_name = "Anna Santos";
$date = date('Y-m-d');
$status = "Present";

$sql_insert = "INSERT INTO attendance (student_name, date, status) VALUES (:student_name, :date, :status)";
$stmt = $conn->prepare($sql_insert);
$stmt->execute([
    'student_name' => $student_name,
    'date' => $date,
    'status' => $status
]);

echo "A new attendance record has been added.<br><br>";

//SELECT all attendance records
$sql_select = "SELECT * FROM attendance";
$stmt = $conn->query($sql_select);
$records = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "Attendance Records:<br>";
foreach ($records as $record) {
    echo "ID: {$record['id']}<br>";
    echo "Name: {$record['student_name']}<br>";
    echo "Date: {$record['date']}<br>";
    echo "Status: {$record['status']}<br><br>";
}

//UPDATE an existing attendance entry
$update_id = 1;
$new_status = "Late";

$sql_update = "UPDATE attendance SET status = :status WHERE id = :id";
$stmt = $conn->prepare($sql_update);
$stmt->execute([
    'status' => $new_status,
    'id' => $update_id
]);

echo "Attendance record with ID $update_id has been updated to '$new_status'.<br><br>";

//DELETE an attendance record
$delete_id = 2;

$sql_delete = "DELETE FROM attendance WHERE id = :id";
$stmt = $conn->prepare($sql_delete);
$stmt->execute(['id' => $delete_id]);

echo "Attendance record with ID $delete_id has been deleted.<br>";
?>
