<?php
require_once "kapcsolat.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Csak POST metódussal érhető el ez a végpont.']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
if (!is_array($input)) {
    http_response_code(400);
    echo json_encode(['error' => 'Nem sikerült értelmezni a JSON bemenetet.']);
    exit;
}

if (empty($input['email']) || empty($input['jelszo'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Hiányzó email vagy jelszó.']);
    exit;
}

$email = $input['email'];
$jelszo = $input['jelszo'];

$stmt = $pdo->prepare('SELECT id, nev, szerepkor, jelszo FROM felhasznalok WHERE email = :email');
$stmt->execute([':email' => $email]);
$user = $stmt->fetch();

if (!$user || $user['jelszo'] !== $jelszo) {
    http_response_code(401);
    echo json_encode(['error' => 'Érvénytelen email vagy jelszó.']);
    exit;
}

echo json_encode([
    'status'  => 'Sikeres bejelentkezés!',
    'user'    => [
        'id'        => (int)$user['id'],
        'nev'       => $user['nev'],
        'szerepkor' => $user['szerepkor'],
        'email'     => $email
    ]
]);
