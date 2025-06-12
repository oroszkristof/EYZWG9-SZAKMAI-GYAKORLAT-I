<?php
require_once "kapcsolat.php";
header('Content-Type: application/json');


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Csak POST kérés engedélyezett']);
    exit;
}


$input = json_decode(file_get_contents("php://input"), true);
if (
    !isset($input['foglalas_id'], $input['ertekeles']) ||
    !is_numeric($input['ertekeles']) ||
    $input['ertekeles'] < 1 || $input['ertekeles'] > 5
) {
    http_response_code(400);
    echo json_encode(['error' => 'Hiányzó vagy érvénytelen adatok']);
    exit;
}

$foglalas_id = (int)$input['foglalas_id'];
$ertekeles = (int)$input['ertekeles'];
$velemeny = isset($input['velemeny']) ? trim($input['velemeny']) : null;

try {
    
    $stmt = $pdo->prepare("
        INSERT INTO ertekelesek (foglalasok_id, ertekeles, velemeny, datum)
        VALUES (:fid, :ert, :v, NOW())
    ");
    $stmt->execute([
        ':fid' => $foglalas_id,
        ':ert' => $ertekeles,
        ':v'   => $velemeny
    ]);

    http_response_code(201);
    echo json_encode(['status' => 'Értékelés rögzítve']);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Adatbázis hiba: ' . $e->getMessage()]);
}