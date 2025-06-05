<?php

$dbHost = 'localhost';
$dbName = 'idopontfoglalo';
$dbUser = 'root';
$dbPass = ''; 

try {
    $pdo = new PDO(
        "mysql:host=$dbHost;dbname=$dbName;charset=utf8",
        $dbUser,
        $dbPass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode([
        'error' => 'Adatbázis kapcsolódási hiba: ' . $e->getMessage()
    ]);
    exit;
}
