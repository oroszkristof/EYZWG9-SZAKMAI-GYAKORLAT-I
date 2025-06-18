<?php
require_once "kapcsolat.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Csak POST metódussal érhető el ez a végpont.']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
if (
    !is_array($input) ||
    !isset($input['szolgaltatok_id'], $input['datum'], $input['ido'])
) {
    http_response_code(400);
    echo json_encode(['error' => 'Hiányzó mezők (szolgaltatok_id, datum, ido).']);
    exit;
}

$szId  = (int)$input['szolgaltatok_id'];
$datum = trim($input['datum']);
$ido   = trim($input['ido']);
$fogl  = isset($input['foglalhato']) ? (int)$input['foglalhato'] : 1;

try {
    $stmt = $pdo->prepare("
        INSERT INTO idopontok (szolgaltatok_id, datum, ido, foglalhato)
        VALUES (:szid, :datum, :ido, :foglalhato)
    ");
    $stmt->execute([
        ':szid' => $szId,
        ':datum' => $datum,
        ':ido' => $ido,
        ':foglalhato' => $fogl
    ]);

    http_response_code(201);
    echo json_encode([
        'status' => 'Időpont sikeresen létrehozva',
        'idopont_id' => (int)$pdo->lastInsertId()
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Adatbázis hiba: ' . $e->getMessage()]);
}