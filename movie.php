<?php
//Database connection
$host = "localhost";
$user = "root";
$password = "";
$dbname = "video_store";

$dsn = "mysql:host=$host;dbname=$dbname";

try {
    $conn = new PDO($dsn, $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected to the database successfully.<br><br>";
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

//INSERT a new movie
$title = "Interstellar";
$director = "Christopher Nolan";
$release_year = 2014;
$available = true;

$sql_insert = "INSERT INTO movies (title, director, release_year, available) VALUES (:title, :director, :release_year, :available)";
$stmt = $conn->prepare($sql_insert);
$stmt->execute([
    'title' => $title,
    'director' => $director,
    'release_year' => $release_year,
    'available' => $available
]);

echo "A new movie has been added.<br><br>";

//SELECT all movies
$sql_select = "SELECT * FROM movies";
$stmt = $conn->query($sql_select);
$movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "All Movies:<br>";
foreach ($movies as $movie) {
    echo "ID: {$movie['id']}<br>";
    echo "Title: {$movie['title']}<br>";
    echo "Director: {$movie['director']}<br>";
    echo "Release Year: {$movie['release_year']}<br>";
    echo "Available: " . ($movie['available'] ? 'Yes' : 'No') . "<br><br>";
}

//UPDATE availability of a movie
$update_id = 1; 
$new_availability = false;
$sql_update = "UPDATE movies SET available = :available WHERE id = :id";
$stmt = $conn->prepare($sql_update);
$stmt->execute([
    'available' => $new_availability,
    'id' => $update_id
]);

echo "Movie with ID $update_id has been updated (availability).<br><br>";

//DELETE a movie
$delete_id = 2;
$sql_delete = "DELETE FROM movies WHERE id = :id";
$stmt = $conn->prepare($sql_delete);
$stmt->execute(['id' => $delete_id]);

echo "Movie with ID $delete_id has been deleted.<br>";
?>
