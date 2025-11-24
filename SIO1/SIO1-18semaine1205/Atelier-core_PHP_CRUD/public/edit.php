<?php
require_once __DIR__ . '/../autoload.php';

use App\User;

$user = new User();
$data = $user->find($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user->update($_GET['id'], $_POST['name'], $_POST['email']);
    header("Location: index.php");
    exit;
}
?>

<h2>Modifier l'utilisateur</h2>
<form method="post">
    Nom: <input name="name" value="<?= htmlspecialchars($data['name']) ?>"><br>
    Email: <input name="email" value="<?= htmlspecialchars($data['email']) ?>"><br>
    <button type="submit">Mettre à jour</button>
</form>
<a href="index.php">Retour</a>

