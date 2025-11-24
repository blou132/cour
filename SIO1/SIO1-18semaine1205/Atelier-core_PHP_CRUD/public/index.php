<?php
require_once __DIR__ . '/../autoload.php';

use App\User;

$user = new User();
$users = $user->all();
?>

<h2>Liste des utilisateurs</h2>
<a href="create.php">+ Ajouter</a>
<table border="1">
    <tr><th>ID</th><th>Nom</th><th>Email</th><th>Actions</th></tr>
    <?php foreach ($users as $u): ?>
        <tr>
            <td><?= $u['id'] ?></td>
            <td><?= htmlspecialchars($u['name']) ?></td>
            <td><?= htmlspecialchars($u['email']) ?></td>
            <td>
                <a href="edit.php?id=<?= $u['id'] ?>">Modifier</a> |
                <a href="delete.php?id=<?= $u['id'] ?>" onclick="return confirm('Supprimer ?')">Supprimer</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>