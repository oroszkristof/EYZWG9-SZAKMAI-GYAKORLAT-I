<?php
require_once "kapcsolat.php";

header('Content-Type: application/json');


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Csak POST metódussal érhető el ez a végpont.']);
    exit;
}


$input = json_decode(file_get_contents('php://input'), true);
if (
    !is_array($input) ||
    !isset($input['nev'], $input['leiras'], $input['szolgaltatas_tipusok_id']) ||
    (!isset($input['aktiv']) && $input['aktiv'] !== 0 && $input['aktiv'] !== 1)
) {
    http_response_code(400);
    echo json_encode(['error' => 'Hiányzó vagy érvénytelen mezők.']);
    exit;
}


$nev                    = trim($input['nev']);
$leiras                 = trim($input['leiras']);
$szolgaltatas_tipusok_id= (int)$input['szolgaltatas_tipusok_id'];
$aktiv                  = (int)$input['aktiv'];


if ($nev === '' || $leiras === '' || $szolgaltatas_tipusok_id <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'A név, leírás és szolgáltatástípus azonosító nem lehet üres.']);
    exit;
}


try {
    $stmtFK = $pdo->prepare('SELECT COUNT(*) FROM szolgaltatas_tipusok WHERE id = :tid');
    $stmtFK->bindParam(':tid', $szolgaltatas_tipusok_id, PDO::PARAM_INT);
    $stmtFK->execute();
    if ($stmtFK->fetchColumn() == 0) {
        http_response_code(400);
        echo json_encode(['error' => 'A megadott szolgáltatás-típus nem létezik.']);
        exit;
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Adatbázis hiba (típus ellenőrzés): ' . $e->getMessage()]);
    exit;
}


try {
    $stmt = $pdo->prepare('
        INSERT INTO szolgaltatok (szolgaltatas_tipusok_id, nev, leiras, aktiv)
        VALUES (:tid, :nev, :leiras, :aktiv)
    ');
    $stmt->bindParam(':tid',   $szolgaltatas_tipusok_id, PDO::PARAM_INT);
    $stmt->bindParam(':nev',   $nev,                     PDO::PARAM_STR);
    $stmt->bindParam(':leiras',$leiras,                  PDO::PARAM_STR);
    $stmt->bindParam(':aktiv', $aktiv,                   PDO::PARAM_INT);
    $stmt->execute();


    $newId = $pdo->lastInsertId();
    http_response_code(201);
    echo json_encode([
        'status' => 'Szolgáltató sikeresen létrehozva',
        'szolgaltato_id' => (int)$newId
    ]);
    exit;
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Adatbázis hiba (szolgáltató létrehozása): ' . $e->getMessage()]);
    exit;
}
