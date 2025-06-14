<?php
//Database connection
$host = "localhost";
$user = "root";
$password = "";
$dbname = "company_db";

$dsn = "mysql:host=$host;dbname=$dbname";

try {
    $conn = new PDO($dsn, $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected to the database successfully.<br><br>";
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

//INSERT a new timelog entry
$employee_name = "Carlos Dela Cruz";
$log_date = date('Y-m-d');
$log_time = date('H:i:s');
$type = "IN";

$sql_insert = "INSERT INTO timelogs (employee_name, log_date, log_time, type) 
               VALUES (:employee_name, :log_date, :log_time, :type)";
$stmt = $conn->prepare($sql_insert);
$stmt->execute([
    'employee_name' => $employee_name,
    'log_date' => $log_date,
    'log_time' => $log_time,
    'type' => $type
]);

echo "New timelog has been added.<br><br>";

//SELECT all timelogs
$sql_select = "SELECT * FROM timelogs";
$stmt = $conn->query($sql_select);
$timelogs = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "Employee Timelogs:<br>";
foreach ($timelogs as $log) {
    echo "ID: {$log['id']}<br>";
    echo "Name: {$log['employee_name']}<br>";
    echo "Date: {$log['log_date']}<br>";
    echo "Time: {$log['log_time']}<br>";
    echo "Type: {$log['type']}<br><br>";
}

//UPDATE a timelog's type
$update_id = 1;
$new_type = "OUT";

$sql_update = "UPDATE timelogs SET type = :type WHERE id = :id";
$stmt = $conn->prepare($sql_update);
$stmt->execute([
    'type' => $new_type,
    'id' => $update_id
]);

echo "Timelog with ID $update_id has been updated to type '$new_type'.<br><br>";

//DELETE a timelog entry
$delete_id = 2;

$sql_delete = "DELETE FROM timelogs WHERE id = :id";
$stmt = $conn->prepare($sql_delete);
$stmt->execute(['id' => $delete_id]);

echo "Timelog with ID $delete_id has been deleted.<br>";
?>
