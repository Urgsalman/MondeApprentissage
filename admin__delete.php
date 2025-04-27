<?php
error_reporting(E_ERROR);
require 'admin.php'; 
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Suppression de contenu</title>
    <style>
        body { font-family: sans-serif; background: #f4f4f4; padding: 40px; }
        form { background: white; padding: 20px; border-radius: 10px; max-width: 600px; margin: auto; }
        select, button { padding: 10px; width: 100%; margin-top: 15px; }
        .hidden { display: none; }
    </style>
    <script>
        function showSelect(type) {
            document.getElementById('categorie-select').style.display = 'none';
            document.getElementById('element-select').style.display = 'none';
            document.getElementById('media-select').style.display = 'none';

            if (type === 'categorie') {
                document.getElementById('categorie-select').style.display = 'block';
            } else if (type === 'element') {
                document.getElementById('element-select').style.display = 'block';
            } else if (type === 'media') {
                document.getElementById('media-select').style.display = 'block';
            }
        }
    </script>
</head>
<body>
    <form action="traitement.php" method="post">
        <h2>Supprimer un contenu</h2>

        <label for="type">Type de contenu :</label>
        <select name="type_suppression" id="type" onchange="showSelect(this.value)" required>
            <option value="">-- Choisir --</option>
            <option value="categorie">Catégorie</option>
            <option value="element">Élément</option>
            <option value="media">Média</option>
        </select>

        <!-- Sélection des catégories -->
        <div id="categorie-select" class="hidden">
            <label>Choisir une catégorie :</label>
            <select name="id_suppression">
                <?php
                $db = Database::getInstance()->getConnection();
                $res = $db->query("SELECT id, nom FROM categories");
                while ($row = $res->fetch_object()) {
                    echo "<option value='{$row->id}'>[{$row->id}] {$row->nom}</option>";
                }
                ?>
            </select>
        </div>

        <!-- Sélection des éléments -->
        <div id="element-select" class="hidden">
            <label>Choisir un élément :</label>
            <select name="id_suppression">
                <?php
                $res = $db->query("SELECT id, titre FROM elements");
                while ($row = $res->fetch_object()) {
                    echo "<option value='{$row->id}'>[{$row->id}] {$row->titre}</option>";
                }
                ?>
            </select>
        </div>

        <!-- Sélection des médias -->
        <div id="media-select" class="hidden">
            <label>Choisir un média :</label>
            <select name="id_suppression">
                <?php
                $res = $db->query("SELECT id, titre FROM medias");
                while ($row = $res->fetch_object()) {
                    $titre = $row->titre ?: "(sans titre)";
                    echo "<option value='{$row->id}'>[{$row->id}] {$titre}</option>";
                }
                ?>
            </select>
        </div>

        <button type="submit" name="supprimer">Supprimer</button>
    </form>
</body>
</html>
