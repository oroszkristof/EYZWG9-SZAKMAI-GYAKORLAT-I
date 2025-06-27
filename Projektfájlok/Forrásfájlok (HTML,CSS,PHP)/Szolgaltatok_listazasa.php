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
            s.id,
            s.nev,
            s.leiras,
            s.aktiv,
            t.nev AS tipus_nev
        FROM szolgaltatok AS s
        LEFT JOIN szolgaltatas_tipusok AS t
            ON s.szolgaltatas_tipusok_id = t.id
        ORDER BY s.id
    ");
    $szolgaltatok = $stmt->fetchAll();

    echo json_encode([
        'status' => 'siker',
        'count'  => count($szolgaltatok),
        'data'   => $szolgaltatok
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Adatbázis hiba: ' . $e->getMessage()]);
    exit;
}
