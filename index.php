<?php
session_start();
require 'admin.php';

if (isset($_POST['login'])) {
    if ($_POST['username'] === 'admin' && $_POST['password'] === 'admin') {
        $_SESSION['logged_in'] = true;
    } else {
        $error = "Identifiants incorrects.";
    }
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}

if (!isset($_SESSION['logged_in'])) {
?>
<form method="post">
    <h2>Connexion</h2>
    <?= isset($error) ? "<p style='color:red;'>\$error</p>" : "" ?>
    <label>Nom d'utilisateur : <input type="text" name="username"></label><br>
    <label>Mot de passe : <input type="password" name="password"></label><br>
    <input type="submit" name="login" value="Connexion">
</form>
<?php
    exit;
}
?>
<h2>Bienvenue, admin</h2>
<a href="?logout=1">Logout</a> |
<a href="afficher.php">Afficher</a> |
<a href="admin_insert.php">Insérer</a> |
<a href="modifier_element.php">Modifier element</a> |
<a href="modifier_categorie.php">Modifier categorie</a> |
<a href="supprimer_element.php">Supprimer element</a> |
<a href="supprimer_categorie.php">Supprimer categorie</a> 