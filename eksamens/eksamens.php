<?php
require_once('eksDb.php');

$db = Db::getInstance()->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $timestamp = time();

    $stmt = $db->prepare('INSERT INTO entries (name, email, message, date) VALUES (:name, :email, :message, :date)');
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->bindValue(':message', $message, PDO::PARAM_STR);
    $stmt->bindValue(':date', $timestamp, PDO::PARAM_INT);
    $stmt->execute();
}

$sort = isset($_GET['sort']) ? $_GET['sort'] : 'id';
$sortOptions = ['name', 'title', 'email', 'date',];

if (!in_array($sort, $sortOptions)) {
    $sort = 'id';
}

$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

$query = "SELECT * FROM entries WHERE LOWER(name) LIKE :search OR LOWER(email) LIKE :search OR LOWER(message) LIKE :search ORDER BY $sort DESC";
$stmt = $db->prepare($query);
$stmt->bindValue(':search', '%' . strtolower($searchTerm) . '%', PDO::PARAM_STR);
$stmt->execute();

$entries = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $entries[] = $row;
}

echo json_encode($entries);