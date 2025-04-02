<?php
// Connexion à la base de données
$host = 'localhost';
$dbname = 'bibliotheque';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Modifier le profil - JobSyn</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
    }

    header {
      background-color: #d3d3d3;
      padding: 10px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .logo {
      font-size: 24px;
      font-weight: bold;
    }

    .container {
      max-width: 800px;
      background-color: #fff;
      margin: 30px auto;
      border-radius: 20px;
      padding: 30px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    h2 {
      text-align: center;
      margin-bottom: 30px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
    }

    input[type="text"],
    textarea {
      width: 100%;
      padding: 10px;
      border-radius: 8px;
      border: 1px solid #ccc;
      font-size: 14px;
    }

    textarea {
      resize: vertical;
      min-height: 80px;
    }

    button {
      padding: 12px 20px;
      background-color: #333;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
      display: block;
      margin: 30px auto 0;
    }

    button:hover {
      background-color: #555;
    }

    .back-link {
      text-align: center;
      margin-top: 20px;
    }

    .back-link a {
      color: #333;
      text-decoration: none;
    }
  </style>
</head>
<body>

  <header>
    <div class="logo">JobSyn</div>
    <div class="back-link"><a href="profil.html">← Retour au profil</a></div>
  </header>

  <div class="container">
    <h2>Modifier le profil</h2>
    <form id="profilForm">
      <div class="form-group">
        <label for="nom">Nom et Prénom</label>
        <input type="text" id="nom" name="nom">
      </div>

      <div class="form-group">
        <label for="poste">Intitulé du poste</label>
        <input type="text" id="poste" name="poste">
      </div>

      <div class="form-group">
        <label for="entreprise">Entreprise / École actuelle</label>
        <input type="text" id="entreprise" name="entreprise">
      </div>

      <div class="form-group">
        <label for="apropos">Description</label>
        <textarea id="apropos" name="description"></textarea>
      </div>

      <div class="form-group">
        <label for="experience">Expérience</label>
        <textarea id="experience" name="experience"></textarea>
      </div>

      <button type="submit">Enregistrer</button>
      <!--  va enregister les infos du candidat en BD, rediriger sur la page profil et les recupérer directement dessus -->
    </form>
  </div>

</body>
</html>
