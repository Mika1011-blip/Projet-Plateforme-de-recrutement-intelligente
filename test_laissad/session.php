<?php
session_start();

// Accepte les requêtes JSON
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// Récupère les données JSON envoyées depuis le fetch()
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data["nom"]) && isset($data["uid"])) {
    $_SESSION["email"] = $data["email"];
    $_SESSION["uid"] = $data["uid"];
    $_SESSION["nom"] = $data["nom"];
    echo json_encode(["message" => "Session initialisée"]);
} else {
    http_response_code(400);
    echo json_encode(["error" => "Données manquantes"]);
}
?>
