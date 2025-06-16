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

if (!isset($_GET['felhasznalo_id']) || !ctype_digit($_GET['felhasznalo_id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Érvénytelen felhasználói azonosító']);
    exit;
}

try {
    $stmt = $pdo->prepare("
        SELECT f.id, i.datum, i.ido, f.allapot, f.megjegyzes
        FROM foglalasok f
        JOIN idopontok i ON f.idopontok_id = i.id
        WHERE f.felhasznalok_id = :fid
        ORDER BY i.datum, i.ido
    ");
    $stmt->execute([':fid' => $_GET['felhasznalo_id']]);
    echo json_encode(['status' => 'Sikeres listázás.', 'data' => $stmt->fetchAll()]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}