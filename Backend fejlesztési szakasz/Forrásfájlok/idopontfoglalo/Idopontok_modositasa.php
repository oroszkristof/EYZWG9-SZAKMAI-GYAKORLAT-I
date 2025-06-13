<?php
require_once "kapcsolat.php";
session_start();

if (!isset($_SESSION['szerepkor'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Bejelentkezés szükséges.']);
    exit;
}

$engedelyezettSzerepkorok = ['admin'];

if (!in_array($_SESSION['szerepkor'], $engedelyezettSzerepkorok)) {
    http_response_code(403);
    echo json_encode(['error' => 'Nincs jogosultság.']);
    exit;
}
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
    http_response_code(405);
    echo json_encode(['error' => 'Csak PUT metódussal érhető el ez a végpont.']);
    exit;
}

if (empty($_GET['id']) || !ctype_digit($_GET['id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Hiányzó vagy érvénytelen id.']);
    exit;
}
$id = (int)$_GET['id'];

$input = json_decode(file_get_contents('php://input'), true);
if (!is_array($input)) {
    http_response_code(400);
    echo json_encode(['error' => 'Nem sikerült értelmezni a JSON bemenetet.']);
    exit;
}

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

$fields = [];
$params = [':id' => $id];

if (isset($input['szolgaltatok_id'])) {
    $fields[] = 'szolgaltatok_id = :szid';
    $params[':szid'] = (int)$input['szolgaltatok_id'];
}
if (isset($input['datum'])) {
    $fields[] = 'datum = :datum';
    $params[':datum'] = trim($input['datum']);
}
if (isset($input['ido'])) {
    $fields[] = 'ido = :ido';
    $params[':ido'] = trim($input['ido']);
}
if (isset($input['foglalhato'])) {
    $fields[] = 'foglalhato = :fogl';
    $params[':fogl'] = (int)$input['foglalhato'];
}

if (empty($fields)) {
    http_response_code(400);
    echo json_encode(['error' => 'Nincs módosítandó mező.']);
    exit;
}

$sql = 'UPDATE idopontok SET ' . implode(', ', $fields) . ' WHERE id = :id';

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    echo json_encode(['status' => 'Időpont sikeresen módosítva']);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Adatbázis hiba (update idopont): ' . $e->getMessage()]);
    exit;
}