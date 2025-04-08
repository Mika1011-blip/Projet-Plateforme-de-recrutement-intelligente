<?php
session_start();

if (isset($_SESSION["nom"])) {
    echo "Bonjour " . $_SESSION["nom"];
} else {
    echo "Aucune session active.";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>JobSyn - Interface IA</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    .chat-container {
      height: 400px;
      overflow-y: auto;
      background-color: #f4f4f4;
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg bg-light-subtle p-2">
    <div class="container-fluid">
      <a class="navbar-brand fw-bold" href="#">JobSyn</a>
      <form class="d-flex mx-auto" role="search">
        <div class="input-group rounded-pill bg-light">
          <span class="input-group-text bg-transparent border-0"><i class="bi bi-list"></i></span>
          <input class="form-control border-0 bg-transparent" type="search" placeholder="Recherche" aria-label="Search">
          <span class="input-group-text bg-transparent border-0"><i class="bi bi-search"></i></span>
        </div>
      </form>
      <ul class="navbar-nav d-flex flex-row gap-4">
        <li class="nav-item text-center">
         <a class="nav-link" href="index.php"> <i class="bi bi-house fs-5"></i><br><small>Accueil</small></a>
        </li>
        <li class="nav-item text-center">
            <a class="nav-link" href="about.php"> <i class="bi bi-people" fs-5"></i><br><small>A propos</small> </a>
        </li>
        <li class="nav-item text-center">
            <a class="nav-link" href="message.php"><i class="bi bi-envelope fs-5"></i><br><small>Messages</small></a>
        </li>
        <li class="nav-item text-center">
          <a class="nav-link" href="notification.php"> <i class="bi bi-bell fs-5"></i><br><small>Notifications</small></a>
        </li>
        <li class="nav-item text-center">
            <a class="nav-link" href="profil.php"><i class="bi bi-person-circle fs-5"></i><br><small>Profil</small></a>
        </li>
      </ul>
    </div>
  </nav>

  <!-- Contenu principal -->
  <div class="container-fluid mt-4">
    <div class="row gx-4">
      <!-- Chat IA -->
      <div class="col-md-4">
        <div class="bg-secondary-subtle rounded-4 p-3">
          <h6 class="fw-bold">CHATBOX IA</h6>
          <div class="chat-container rounded-3 p-3 mb-3">
            <p><strong>IA:</strong> BONJOUR ! COMMENT PUIS-JE VOUS AIDER ?</p>
          </div>
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Tapez votre message...">
            <button class="btn btn-dark">Envoyer</button>
          </div>
        </div>
      </div>

      <!-- Offres d'emplois -->
      <div class="col-md-8">


          <div class="container py-4 bg-secondary-subtle rounded-4 p-3">
            <div class="row align-items-center">
              <div class="col-md-3 mb-4">
                
              </div>

              <div class="col-md-6">
                <h2 class="fw-bold text-primary mb-3">Bienvenue sur RecruteX</h2>
                <p class="lead">
                  RecruteX est une plateforme intelligente conçue pour faciliter la mise en relation entre les entreprises et les talents. Que vous soyez une startup en pleine croissance ou un candidat à la recherche d'une opportunité professionnelle, notre solution s’adapte à vos besoins.
                </p>
                <ul class="list-group list-group-flush mb-3">
                  <li class="list-group-item"> Recherche simplifiée d'offres et de profils</li>
                  <li class="list-group-item"> Système de matching intelligent</li>
                  <li class="list-group-item"> Statistiques et suivi des candidatures en temps réel</li>
                  <li class="list-group-item"> Sécurité et confidentialité des données</li>
                </ul>
                <a href="#about" class="btn btn-primary mt-3">En savoir plus</a>
                <a href="./ProjetHackaton/frontend/candidate.html" class="btn btn-primary mt-3">Accéder aux offres</a>
              </div>

              <div class="col-md-3 mb-4">
                
              </div>

            </div>
          </div>


      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
