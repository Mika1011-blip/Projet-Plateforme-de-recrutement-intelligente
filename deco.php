<?php 
session_start();
unset($_SESSION['nom']);
session_destroy();

header('Location: ./index.php');

#fichier de déconexion de l'administrateur