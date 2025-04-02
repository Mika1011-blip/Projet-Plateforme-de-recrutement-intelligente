<?php
// Connexion à la base de données
$host = 'localhost';
$dbname = 'hackathon';
$username = 'root';
$password = '';
$profil = [];


  if(isset($_POST['add'])) {
      try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Erreur de connexion : " . $e->getMessage());
    }

    // Traitement du formulaire lorsqu'il est soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Récupération des données du formulaire
      $nom = $_POST['nom'] ?? '';
      $poste = $_POST['poste'] ?? '';
      $entreprise = $_POST['entreprise'] ?? '';
      $description = $_POST['description'] ?? '';
      $experience = $_POST['experience'] ?? '';
      
        try {
                // Préparation de la requête d'insertion
                $stmt = $pdo->prepare("INSERT INTO profil (nom_candidat, intituler_poste, ecole, description, experience) 
                                VALUES (:nom_candidat, :intituler_poste, :ecole, :description, :experience)");
                
                // Exécution de la requête avec les paramètres
                $stmt->execute([
                ':nom_candidat' => $nom,
                ':intituler_poste' => $poste,
                ':ecole' => $entreprise,
                ':description' => $description,
                ':experience' => $experience
                ]);
                
        } catch (PDOException $e) {
                die("Erreur lors de l'insertion : " . $e->getMessage());
        }
      }
    
    // Récupération des données du profil 
    try {
        $stmt = $pdo->query("SELECT * FROM profil ORDER BY id_candidat DESC LIMIT 1"); // Récupère le dernier profil ajouté
        $profil = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erreur lors de la récupération du profil : " . $e->getMessage());
    }
  }


?>


<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profil Utilisateur</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    .profile-card {
      max-width: 80%;
      margin: 50px auto;
      padding: 30px;
      background-color: #ddd;
      border-radius: 20px;
    }
    .profile-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .profile-info {
      display: flex;
      align-items: center;
      gap: 20px;
    }
    .profile-info img {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      border: 5px solid white;
      background-color: white;
    }
    .profile-text {
      line-height: 1.2;
    }
    .profile-text h5 {
      margin: 0;
      font-weight: bold;
    }
    .profile-text small {
      display: block;
      color: #333;
    }
    .section-title {
      font-weight: bold;
      margin-top: 30px;
    }
    .logout {
      text-align: right;
      margin-top: 40px;
    }
  </style>
</head>
<body>

    
<!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-light shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">JobSyn</a>

        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
                <li class="nav-item text-center mx-2">
                    <a class="nav-link" href="index.html"><i class="bi bi-house"></i><br>Accueil</a>
                </li>
                <li class="nav-item text-center mx-2">
                    <a class="nav-link" href="emploie.html"><i class="bi bi-people"></i><br>Emplois</a>
                </li>
                <li class="nav-item text-center mx-2">
                    <a class="nav-link" href="message.html"><i class="bi bi-envelope"></i><br>Messagerie</a>
                </li>
                <li class="nav-item text-center mx-2">
                    <a class="nav-link" href="notification.html"><i class="bi bi-bell"></i><br>Notification</a>
                </li>
                <li class="nav-item text-center mx-2">
                    <a class="nav-link active" href="profil.html"><i class="bi bi-person-circle"></i><br>Profil</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

  <div class="profile-card">
    <div class="profile-header">
      <div class="profile-info">
        <img src="https://img.icons8.com/ios-filled/100/user-male-circle.png" alt="Avatar">
        <div class="profile-text">
          <h5>Nom Prénom</h5>
          <small>Intitulé du poste</small>
          <small>Entreprise ou école actuelle</small>
        </div>
      </div>
      
      <div>
      

      <form action="modifProfil.php" method="post">
      <?php if ($profil){ ?>
        <input type="text" name="id" value="<?php echo htmlspecialchars($profil['id_candidat']); ?>">
        <a href="modifProfil.php" class="btn btn-secondary">Modifier le profil <i class="bi bi-pencil"></i></a>
        <input type="submit" name="mod1">
      <?php } ?>
      </form>

      </div>
    </div>
    

    <div class="container">
    <h2>Mon Profil</h2>
    
    <?php if ($profil): ?>
      <div class="profil-info">
        <h3>Nom et Prénom</h3>
        <p><?php echo htmlspecialchars($profil['nom_candidat'] ?? 'Non renseigné'); ?></p>
      </div>

      <div class="profil-info">
        <h3>Intitulé du poste</h3>
        <p><?php echo htmlspecialchars($profil['intituler_poste'] ?? 'Non renseigné'); ?></p>
      </div>

      <div class="profil-info">
        <h3>Entreprise / École actuelle</h3>
        <p><?php echo htmlspecialchars($profil['ecole'] ?? 'Non renseigné'); ?></p>
      </div>

      <div class="profil-info">
        <h3>Description</h3>
        <p><?php echo nl2br(htmlspecialchars($profil['description'] ?? 'Non renseigné')); ?></p>
      </div>

      <div class="profil-info">
        <h3>Expérience</h3>
        <p><?php echo nl2br(htmlspecialchars($profil['experience'] ?? 'Non renseigné')); ?></p>
      </div>

      
    <?php else: ?>
      <div class="profil-info">
        <p>Aucun profil trouvé. <a href="addprofil.php" class="btn btn-primary">Créer un profil</a></p>
      </div>
    <?php endif; ?>
  </div>

    <div class="logout">
      <i class="bi bi-gear"></i> <a href="deco.html">Déconnexion</a>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
