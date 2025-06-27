<?php
require_once("kapcsolat.php");

header('Content-Type: application/json');

echo json_encode(["status" => "sikeres kapcsolat"]);
?>
