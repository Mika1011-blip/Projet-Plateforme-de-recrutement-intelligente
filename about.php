<?php
session_start();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>JobSyn - Recherche Emplois</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-light shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">JobSyn</a>
    
            <div class="collapse navbar-collapse justify-content-end">
                <ul class="navbar-nav">
                    <li class="nav-item text-center mx-2">
                        <a class="nav-link" href="index.php"><i class="bi bi-house"></i><br>Accueil</a>
                    </li>
                    <li class="nav-item text-center mx-2">
                        <a class="nav-link" href="about.php"><i class="bi bi-people"></i><br>A propos</a>
                    </li>
                    <li class="nav-item text-center mx-2">
                        <a class="nav-link" href="message.php"><i class="bi bi-envelope"></i><br>Messagerie</a>
                    </li>
                    <li class="nav-item text-center mx-2">
                        <!-- <a class="nav-link" href="notification.php"><i class="bi bi-bell"></i><br>Notification</a> -->
                        <a class="nav-link" href="./ProjetHackaton/frontend/candidate.php"><i class="bi bi-bell"></i><br>Nos offres</a>
                    </li>
                    <li class="nav-item text-center mx-2">
                        <a class="nav-link active" href="profil.php"><i class="bi bi-person-circle"></i><br>Profil</a>
                    </li>
                    <li>
                        <?php
                            if (isset($_SESSION["nom"])) {
                                echo "Bonjour " . $_SESSION["nom"];
                            } else {
                                echo "<a class='btn btn-primary' href='./test_laissad/decoData.html'>se connecter</a>";
                            }
                        ?>
                    </li>
                </ul>
            </div>
        </div>
</nav>

<!-- Contenu principal -->
 <div class="container">
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-12" style="background-color:rgb(236, 235, 236); border-radius: 20px;">
            <div class="p-4  rounded shadow-sm" >
            <div class="container py-5">
                <!-- Bloc 1 -->
                <div class="row align-items-center mb-5">
                    <div class="col-md-6">
                    <img src="https://cdn-icons-png.flaticon.com/512/3105/3105807.png" class="img-fluid rounded" alt="À propos de nous">
                    </div>
                    <div class="col-md-6">
                    <h2 class="fw-bold text-primary">Qui sommes-nous ?</h2>
                    <p>
                        JobSyn est une plateforme innovante dédiée à la mise en relation entre les talents et les entreprises. 
                        Nous simplifions le processus de recrutement grâce à des outils performants et intuitifs, adaptés à tous les profils.
                    </p>
                    </div>
                </div>

                <!-- Bloc 2 -->
                <div class="row align-items-center mb-5 flex-md-row-reverse">
                    <div class="col-md-6">
                    <img src="https://cdn-icons-png.flaticon.com/512/2936/2936704.png" class="img-fluid rounded" alt="Notre mission">
                    </div>
                    <div class="col-md-6">
                    <h2 class="fw-bold text-primary">Notre mission</h2>
                    <p>
                        Offrir une expérience de recrutement transparente, rapide et efficace. 
                        Nous mettons à disposition des outils d'analyse, de tri intelligent des candidatures et de matching automatisé pour optimiser le processus.
                    </p>
                    </div>
                </div>

                <!-- Bloc 3 -->
                <div class="row align-items-center">
                    <div class="col-md-6">
                    <img src="https://cdn-icons-png.flaticon.com/512/5454/5454331.png" class="img-fluid rounded" alt="Notre vision">
                    </div>
                    <div class="col-md-6">
                    <h2 class="fw-bold text-primary">Notre vision</h2>
                    <p>
                        Être le lien incontournable entre les recruteurs et les chercheurs d’emploi à travers une technologie moderne 
                        et une interface centrée sur l’humain. L’objectif : placer la bonne personne au bon poste.
                    </p>
                    </div>
                </div>
                </div>

            </div>
        </div>
    </div>
</div>
</div>


<div class="container">
  <footer class="pt-4 mt-4 border-top">
    <div class="row">
      <!-- Logo & Description -->
      <div class="col-md-4 mb-3">
        <h5 class="fw-bold text-primary">JobSyn</h5>
        <p class="text-muted">
          JobSyn est une plateforme de recrutement en ligne qui connecte les talents aux meilleures opportunités d’emploi. Simple, rapide et efficace.
        </p>
      </div>

      <!-- Liens utiles -->
      <div class="col-md-4 mb-3">
        <h6 class="fw-semibold">Liens utiles</h6>
        <ul class="list-unstyled">
          <li><a href="#" class="text-decoration-none text-muted">Accueil</a></li>
          <li><a href="#" class="text-decoration-none text-muted">Offres d'emploi</a></li>
          <li><a href="#" class="text-decoration-none text-muted">Candidats</a></li>
          <li><a href="#" class="text-decoration-none text-muted">Contact</a></li>
        </ul>
      </div>

      <!-- Contact -->
      <div class="col-md-4 mb-3">
        <h6 class="fw-semibold">Nous contacter</h6>
        <p class="text-muted mb-1"> Paris, France</p>
        <p class="text-muted mb-1"> +33 77 123 45 67</p>
        <p class="text-muted">📧 contact@jobsyn.com</p>
      </div>
    </div>

    <!-- Bas de page -->
    <div class="d-flex justify-content-between align-items-center pt-3 mt-3 border-top">
      <p class="mb-0 text-muted">&copy; 2025 JobSyn. Tous droits réservés.</p>
      <div>
        <a href="#" class="text-muted me-3"><i class="fab fa-facebook"></i></a>
        <a href="#" class="text-muted me-3"><i class="fab fa-twitter"></i></a>
        <a href="#" class="text-muted"><i class="fab fa-linkedin"></i></a>
      </div>
    </div>
  </footer>
  </div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
