<?php
require_once "kapcsolat.php";
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['error' => 'Csak GET kérés engedélyezett.']);
    exit;
}

if (!isset($_GET['szolgaltato_id']) || !ctype_digit($_GET['szolgaltato_id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Érvénytelen vagy hiányzó szolgáltató ID.']);
    exit;
}

$szolgaltatoId = (int)$_GET['szolgaltato_id'];

try {
    $stmt = $pdo->prepare("
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
        WHERE sz.id = :szid
        ORDER BY e.datum DESC
    ");
    $stmt->execute([':szid' => $szolgaltatoId]);
    $adatok = $stmt->fetchAll();

    echo json_encode([
        'status' => 'siker',
        'count'  => count($adatok),
        'data'   => $adatok
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Adatbázis hiba: ' . $e->getMessage()]);
}