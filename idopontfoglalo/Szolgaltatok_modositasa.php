<?php
require_once "kapcsolat.php";

header('Content-Type: application/json');


if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
    http_response_code(405);
    echo json_encode(['error' => 'Csak PUT metódussal érhető el ez a végpont.']);
    exit;
}


if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Hiányzó vagy érvénytelen szolgáltató-id.']);
    exit;
}
$szolgaltato_id = (int)$_GET['id'];


$input = json_decode(file_get_contents('php://input'), true);
if (!is_array($input)) {
    http_response_code(400);
    echo json_encode(['error' => 'Nem sikerült értelmezni a JSON bemenetet.']);
    exit;
}


try {
    $stmtCheck = $pdo->prepare('SELECT COUNT(*) FROM szolgaltatok WHERE id = :id');
    $stmtCheck->bindParam(':id', $szolgaltato_id, PDO::PARAM_INT);
    $stmtCheck->execute();
    if ($stmtCheck->fetchColumn() == 0) {
        http_response_code(404);
        echo json_encode(['error' => 'A megadott szolgáltató nem található.']);
        exit;
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Adatbázis hiba (létezés ellenőrzés): ' . $e->getMessage()]);
    exit;
}


$fieldsToUpdate = [];
$params = [ ':id' => $szolgaltato_id ];

if (isset($input['nev'])) {
    $fieldsToUpdate[] = 'nev = :nev';
    $params[':nev'] = trim($input['nev']);
}
if (isset($input['leiras'])) {
    $fieldsToUpdate[] = 'leiras = :leiras';
    $params[':leiras'] = trim($input['leiras']);
}
if (isset($input['szolgaltatas_tipusok_id'])) {
    $fieldsToUpdate[] = 'szolgaltatas_tipusok_id = :tid';
    $params[':tid'] = (int)$input['szolgaltatas_tipusok_id'];
}
if (isset($input['aktiv'])) {
    $fieldsToUpdate[] = 'aktiv = :aktiv';
    $params[':aktiv'] = (int)$input['aktiv'];
}

if (empty($fieldsToUpdate)) {
   
    http_response_code(400);
    echo json_encode(['error' => 'Nincs megadva egyetlen módosítandó mező sem.']);
    exit;
}


if (isset($params[':tid'])) {
    try {
        $stmtFK = $pdo->prepare('SELECT COUNT(*) FROM szolgaltatas_tipusok WHERE id = :tid');
        $stmtFK->bindParam(':tid', $params[':tid'], PDO::PARAM_INT);
        $stmtFK->execute();
        if ($stmtFK->fetchColumn() == 0) {
            http_response_code(400);
            echo json_encode(['error' => 'A megadott (új) szolgáltatás-típus nem létezik.']);
            exit;
        }
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Adatbázis hiba (típus ellenőrzés): ' . $e->getMessage()]);
        exit;
    }
}


$sql = 'UPDATE szolgaltatok SET ' . implode(', ', $fieldsToUpdate) . ' WHERE id = :id';

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    http_response_code(200);
    echo json_encode(['status' => 'Szolgáltató sikeresen módosítva']); 
    exit;
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Adatbázis hiba (szolgáltató módosítása): ' . $e->getMessage()]);
    exit;
}
