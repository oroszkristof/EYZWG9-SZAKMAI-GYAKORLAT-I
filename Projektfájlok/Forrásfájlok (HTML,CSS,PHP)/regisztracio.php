<?php
require_once 'kapcsolat.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Csak POST metódussal érhető el ez a végpont.']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
if (
    !isset($input['nev'], $input['email'], $input['jelszo'], $input['szerepkor']) ||
    !in_array($input['szerepkor'], ['felhasznalo', 'admin'], true)
) {
    http_response_code(400);
    echo json_encode(['error' => 'Nem sikerült értelmezni a JSON bemenetet, vagy hiányzó/érvénytelen mező.']);
    exit;
}

$nev = trim($input['nev']);
$email = trim($input['email']);
$jelszo = trim($input['jelszo']);
$szerepkor = $input['szerepkor'];

if ($nev === '' || $email === '' || $jelszo === '') {
    http_response_code(400);
    echo json_encode(['error' => 'A név, email és jelszó mezők nem lehetnek üresek.']);
    exit;
}


try {
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM felhasznalok WHERE email = :email');
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    if ($stmt->fetchColumn() > 0) {
        http_response_code(409);
        echo json_encode(['error' => 'Ez az email már regisztrálva van.']);
        exit;
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Adatbázis hiba: ' . $e->getMessage()]);
    exit;
}

try {
    $stmt = $pdo->prepare('INSERT INTO felhasznalok (nev, email, jelszo, szerepkor) VALUES (:nev, :email, :jelszo, :szerepkor)');
    $stmt->bindParam(':nev', $nev, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':jelszo', $jelszo, PDO::PARAM_STR);
    $stmt->bindParam(':szerepkor', $szerepkor, PDO::PARAM_STR);
    $stmt->execute();

    $newId = $pdo->lastInsertId();
    http_response_code(201);
    echo json_encode([
        'status' => 'Sikeres regisztracio',
        'felhasznalo_id' => $newId
    ]);
    exit;
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Adatbázis hiba: ' . $e->getMessage()]);
    exit;
}
