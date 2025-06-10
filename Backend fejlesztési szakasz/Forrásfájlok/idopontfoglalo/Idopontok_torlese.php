<?php
require_once "kapcsolat.php";
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    http_response_code(405);
    echo json_encode(['error' => 'Csak DELETE metódussal érhető el ez a végpont.']);
    exit;
}

if (empty($_GET['id']) || !ctype_digit($_GET['id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Hiányzó vagy érvénytelen id.']);
    exit;
}
$id = (int)$_GET['id'];

try {
    $stmtChk = $pdo->prepare('SELECT COUNT(*) FROM idopontok WHERE id = :id');
    $stmtChk->execute([':id' => $id]);
    if ($stmtChk->fetchColumn() == 0) {
        http_response_code(404);
        echo json_encode(['error' => 'Nincs ilyen id-jú időpont.']);
        exit;
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Adatbázis hiba (ellenőrzés): ' . $e->getMessage()]);
    exit;
}

try {
    $stmt = $pdo->prepare('DELETE FROM idopontok WHERE id = :id');
    $stmt->execute([':id' => $id]);
    echo json_encode(['status' => 'Időpont sikeresen törölve']);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Adatbázis hiba (delete idopont): ' . $e->getMessage()]);
    exit;
}