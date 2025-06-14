<?php
// Database connection
$host = "localhost";
$user = "root";
$password = "";
$dbname = "library";

$dsn = "mysql:host=$host;dbname=$dbname";

try {
    $conn = new PDO($dsn, $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected to the database successfully.<br><br>";
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

//INSERT a new book
$title = "Harry Potter and the Goblet of Fire";
$author = "J.K. Rowling";
$published_year = 2000;
$genre = "Fantasy";

$sql_insert = "INSERT INTO books (title, author, published_year, genre) VALUES (:title, :author, :published_year, :genre)";
$stmt = $conn->prepare($sql_insert);
$stmt->execute([
    'title' => $title,
    'author' => $author,
    'published_year' => $published_year,
    'genre' => $genre
]);

echo "A new book has been added.<br><br>";

//SELECT all books
$sql_select = "SELECT * FROM books";
$stmt = $conn->query($sql_select);
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "All Books:<br>";
foreach ($books as $book) {
    echo "ID: {$book['id']}<br>";
    echo "Title: {$book['title']}<br>";
    echo "Author: {$book['author']}<br>";
    echo "Year: {$book['published_year']}<br>";
    echo "Genre: {$book['genre']}<br><br>";
}

//UPDATE a book's title
$update_id = 1; 
$new_title = "Marvel's Infinity War: The Novel";
$sql_update = "UPDATE books SET title = :title WHERE id = :id";
$stmt = $conn->prepare($sql_update);
$stmt->execute([
    'title' => $new_title,
    'id' => $update_id
]);

echo "Book with ID $update_id has been updated.<br><br>";

//DELETE a book
$delete_id = 2; 
$sql_delete = "DELETE FROM books WHERE id = :id";
$stmt = $conn->prepare($sql_delete);
$stmt->execute(['id' => $delete_id]);

echo "Book with ID $delete_id has been deleted.<br>";
?>

