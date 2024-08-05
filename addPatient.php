<?php
$host = 'localhost';
$db = 'triage_db';
$user = 'root';
$pass = '';

$pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);


header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    $name = $_POST['patient-name'];
    $severity = $_POST['severity'];

    
    $stmt = $pdo->prepare('INSERT INTO patients (name, severity) VALUES (?, ?)');
    $result = $stmt->execute([$name, $severity]);

  
    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add patient.']);
    }
    exit;
}
