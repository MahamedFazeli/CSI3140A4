<?php
$host = 'localhost';
$db = 'triage_db';
$user = 'root';
$pass = '';

$pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $stmt = $pdo->query('SELECT * FROM patients ORDER BY severity DESC, created_at ASC');
    $patients = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($patients);
    exit;
}