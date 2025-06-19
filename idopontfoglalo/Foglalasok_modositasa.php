<?php
require_once "kapcsolat.php";

header('Content-Type: application/json');

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Hiányzó vagy hibás foglalás ID']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$fields = [];
$params = [':id' => $_GET['id']];

if (isset($input['allapot'])) {
    $fields[] = 'allapot = :a';
    $params[':a'] = $input['allapot'];
}
if (isset($input['megjegyzes'])) {
    $fields[] = 'megjegyzes = :m';
    $params[':m'] = $input['megjegyzes'];
}

if (empty($fields)) {
    http_response_code(400);
    echo json_encode(['error' => 'Nincs módosítandó mező']);
    exit;
}

$sql = "UPDATE foglalasok SET " . implode(', ', $fields) . " WHERE id = :id";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    echo json_encode(['status' => 'Foglalás módosítva']);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}