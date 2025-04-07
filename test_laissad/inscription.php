<?php
// CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json");

// Connexion MySQL
$host = "localhost";
$user = "root";
$password = "";
$dbname = "auth_demo";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Erreur de connexion à la base de données."]);
    exit;
}

// Récupération des données JSON
$data = json_decode(file_get_contents("php://input"), true);

// Vérification des champs
if (
    isset($data["uid"]) &&
    isset($data["email"]) &&
    isset($data["role"]) &&
    isset($data["dateInscription"]) &&
    isset($data["nom"]) &&
    isset($data["prenom"]) &&
    isset($data["phone"])
) {
    $uid = $conn->real_escape_string($data["uid"]);
    $email = $conn->real_escape_string($data["email"]);
    $role = $conn->real_escape_string($data["role"]);
    $date = $conn->real_escape_string($data["dateInscription"]);
    $nom = $conn->real_escape_string($data["nom"]);
    $prenom = $conn->real_escape_string($data["prenom"]);
    $phone = $conn->real_escape_string($data["phone"]);

    $sql = "INSERT INTO utilisateurs (uid, email, role, date_inscription, nom, prenom, phone)
            VALUES ('$uid', '$email', '$role', '$date', '$nom', '$prenom', '$phone')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Utilisateur enregistré avec succès dans MySQL."]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Erreur MySQL : " . $conn->error]);
    }
} else {
    http_response_code(400);
    echo json_encode(["error" => "Données incomplètes."]);
}

$conn->close();
?>
