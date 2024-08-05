<?php
$dsn = 'mysql:host=localhost;dbname=triage_db';
$dbusername = 'root';
$dbpassword = '';

try {
    $pdo = new PDO($dsn, $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Could not connect to the database: " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['patient-name'];
    $severity = $_POST['severity'];

    $stmt = $pdo->prepare('INSERT INTO patients (name, severity) VALUES (?, ?)');
    $stmt->execute([$name, $severity]);

    echo json_encode(['success' => true]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $pdo->query('SELECT * FROM patients ORDER BY severity DESC, created_at ASC');
    $patients = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($patients);
    exit;
}
?>