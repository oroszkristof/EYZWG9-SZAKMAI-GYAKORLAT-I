<?php
require_once "kapcsolat.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['error' => 'Csak GET metódussal érhető el ez a végpont.']);
    exit;
}

try {
    $stmt = $pdo->query("
        SELECT 
            i.id,
            i.szolgaltatok_id,
            i.datum,
            i.ido,
            i.foglalhato,
            sz.nev AS szolgaltato_nev
        FROM idopontok i
        LEFT JOIN szolgaltatok sz ON i.szolgaltatok_id = sz.id
        ORDER BY i.datum, i.ido
    ");
    $idopontok = $stmt->fetchAll();

    echo json_encode([
        'status' => 'siker',
        'count'  => count($idopontok),
        'data'   => $idopontok
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Adatbázis hiba: ' . $e->getMessage()]);
}