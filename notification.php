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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>JobSyn - Notifications</title>
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
                        <a class="nav-link" href="notification.php"><i class="bi bi-bell"></i><br>Notification</a>
                    </li>
                    <li class="nav-item text-center mx-2">
                        <a class="nav-link active" href="profil.php"><i class="bi bi-person-circle"></i><br>Profil</a>
                    </li>
                </ul>
            </div>
        </div>
</nav>

<!-- Notifications -->
<div class="container mt-5">
    <h4 class="mb-4">TOUTE VOS NOTIFICATIONS</h4>

    <div class="list-group">
        <div class="list-group-item mb-3 bg-light rounded shadow-sm">Notification 1</div>
        <div class="list-group-item mb-3 bg-light rounded shadow-sm">Notification 2</div>
        <div class="list-group-item mb-3 bg-light rounded shadow-sm">Notification 3</div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>