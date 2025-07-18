<?php
require_once "kapcsolat.php";

header('Content-Type: application/json');

if (!isset($_GET['felhasznalo_id']) || !ctype_digit($_GET['felhasznalo_id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Érvénytelen felhasználói azonosító']);
    exit;
}

try {
    
    $stmt = $pdo->prepare("
        SELECT 
          f.id,
          i.datum,
          i.ido,
          f.foglalasi_ido,
          f.allapot,
          f.megjegyzes
        FROM foglalasok f
        JOIN idopontok i ON f.idopontok_id = i.id
        WHERE f.felhasznalok_id = :fid
        ORDER BY f.foglalasi_ido DESC
    ");
    $stmt->execute([':fid' => $_GET['felhasznalo_id']]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
      'status' => 'siker',
      'data'   => $rows
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
