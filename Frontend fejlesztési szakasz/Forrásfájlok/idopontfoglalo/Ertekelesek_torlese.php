<?php
require_once "kapcsolat.php";
session_start();

header('Content-Type: application/json');


// Metódus ellenőrzése (POST-ot várunk, NEM DELETE-et!)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Csak POST metódussal érhető el ez a végpont.']);
    exit;
}

// ID ellenőrzés
if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Hiányzó vagy érvénytelen értékelés ID']);
    exit;
}

$id = (int)$_GET['id'];

try {
    $stmt = $pdo->prepare("DELETE FROM ertekelesek WHERE id = :id");
    $stmt->execute([':id' => $id]);
    if ($stmt->rowCount() === 0) {
        http_response_code(404);
        echo json_encode(['error' => 'Nincs ilyen értékelés vagy már törölve lett.']);
        exit;
    }
    echo json_encode(['status' => 'siker', 'message' => 'Értékelés törölve.']);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Adatbázis hiba: ' . $e->getMessage()]);
}
