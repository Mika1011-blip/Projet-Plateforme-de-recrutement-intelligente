<?php
session_start();

if (isset($_SESSION["nom"])) {
    echo "Bonjour " . $_SESSION["nom"];
} else {
    echo "Aucune session active.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Page PHP</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
</head>
<body>
    <p>Bienvenue, <?php echo $_SESSION['nom']; ?> !</p>
    <p>Bonjour, nous sommes ravis de vous voir ici 👋</p>
</body>
</html>
