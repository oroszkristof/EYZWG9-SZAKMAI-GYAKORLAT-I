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
            e.id,
            f.nev AS felhasznalo_nev,
            sz.nev AS szolgaltato_nev,
            e.ertekeles,
            e.velemeny,
            e.datum
        FROM ertekelesek e
        JOIN foglalasok fg ON e.foglalasok_id = fg.id
        JOIN felhasznalok f ON fg.felhasznalok_id = f.id
        JOIN idopontok i ON fg.idopontok_id = i.id
        JOIN szolgaltatok sz ON i.szolgaltatok_id = sz.id
        ORDER BY e.datum DESC
    ");
    $adatok = $stmt->fetchAll();

    echo json_encode([
        'status' => 'Sikeres listázás.',
        'count' => count($adatok),
        'data' => $adatok
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Adatbázis hiba: ' . $e->getMessage()]);
}
