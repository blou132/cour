<?php

require_once __DIR__ . '/../autoload.php';

use App\User;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    (new User())->create($_POST['name'], $_POST['email']);
    header("Location: index.php");
    exit;
}
?>

<h2>Ajouter un utilisateur</h2>
<form method="post">
    Nom: <input type="text" name="name"><br>
    Email: <input type="text" name="email"><br>
    <button type="submit">Ajouter</button>
</form>
<a href="index.php">Retour</a>

