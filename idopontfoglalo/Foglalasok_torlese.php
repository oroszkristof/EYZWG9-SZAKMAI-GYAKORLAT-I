<?php
require_once "kapcsolat.php";
session_start();

if (!isset($_SESSION['szerepkor'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Bejelentkezés szükséges.']);
    exit;
}

$engedelyezettSzerepkorok = ['felhasznalo'];

if (!in_array($_SESSION['szerepkor'], $engedelyezettSzerepkorok)) {
    http_response_code(403);
    echo json_encode(['error' => 'Nincs jogosultság.']);
    exit;
}
header('Content-Type: application/json');

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Érvénytelen foglalás ID']);
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM foglalasok WHERE id = :id");
    $stmt->execute([':id' => $_GET['id']]);
    echo json_encode(['status' => 'Foglalás törölve']);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}