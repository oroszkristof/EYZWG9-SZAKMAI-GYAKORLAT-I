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

$input = json_decode(file_get_contents("php://input"), true);
if (!isset($input['felhasznalo_id'], $input['idopont_id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Hiányzó mezők']);
    exit;
}

try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("INSERT INTO foglalasok (felhasznalok_id, idopontok_id, allapot, megjegyzes)
                           VALUES (:fid, :iid, 'lefoglalt', :msg)");
    $stmt->execute([
        ':fid' => $input['felhasznalo_id'],
        ':iid' => $input['idopont_id'],
        ':msg' => $input['megjegyzes'] ?? null
    ]);

    $pdo->prepare("UPDATE idopontok SET foglalhato = 0 WHERE id = :iid")
        ->execute([':iid' => $input['idopont_id']]);

    $pdo->commit();
    echo json_encode(['status' => 'Sikeres foglalás']);
} catch (PDOException $e) {
    $pdo->rollBack();
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}