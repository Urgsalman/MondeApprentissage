<?php
require 'admin.php';
$db = Database::getInstance()->getConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
	$chemin_fichier = $_POST['chemin_fichier_existant']; 
	$chemin_fichier = $_POST['chemin_fichier_existant']; 
if (isset($_FILES['chemin_fichier']) && $_FILES['chemin_fichier']['error'] == 0) {
    $target_dir = 'uploads/';
    $file_info = pathinfo($_FILES['chemin_fichier']['name']);
    $chemin_fichier = $target_dir . basename($file_info['basename']);
    if (move_uploaded_file($_FILES['chemin_fichier']['tmp_name'], $chemin_fichier)) {
        $image = $chemin_fichier;
    } else {
        echo 'Erreur lors de l\'upload du fichier.';
    }
} else {
    $image = $chemin_fichier;
}
    $categorie_id = $_POST['categorie_id'];
    $categorie = new Categorie($nom, $image);
    $categorie->miseajour($categorie_id);
    echo "Catégorie mise à jour.";
}

$result = $db->query("SELECT * FROM categories");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une catégorie</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f5f5f5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }

        h2 {
            color: #333;
            margin-bottom: 1.5rem;
            text-align: center;
            font-weight: 600;
        }

        form div {
            margin-bottom: 1.2rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            color: #555;
            font-weight: 500;
        }

        input[type="text"],
        input[type="file"],
        select {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 0.9rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        select {
            appearance: none;
            background: white url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%23333' viewBox='0 0 16 16'%3E%3Cpath d='M8 11l-4-4h8l-4 4z'/%3E%3C/svg%3E") no-repeat right 1rem center;
        }

        input[type="text"]:focus,
        select:focus {
            outline: none;
            border-color: #2196F3;
            box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.1);
        }

        input[type="submit"] {
            width: 100%;
            padding: 0.8rem;
            background-color: #2196F3;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #1976D2;
            transform: translateY(-2px);
        }

        .success-message {
            background-color: #4CAF50;
            color: white;
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1rem;
            text-align: center;
        }
        .btn-back {
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #4CAF50;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            z-index: 1000;
            min-width: 200px;
            text-align: center;
        }

        .btn-back:hover {
            background-color: #45a049;
            transform: translateX(-50%) translateY(-2px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        }

        @media (max-width: 768px) {
            .btn-back {
                position: static;
                display: block;
                transform: none;
                margin: 20px auto;
                width: fit-content;
            }

            .btn-back:hover {
                transform: translateY(-2px);
            }
        }
        @media (max-width: 768px) {
            .container {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <a href="admin_interface.php" class="btn btn-back">Retour à l'accueil</a>
    <div class="container">
        <?php if (isset($message)): ?>
            <div class="success-message"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
        
        <form method="post" enctype="multipart/form-data">
            <h2>Modifier une catégorie</h2>
            
            <div>
                <label for="categorie_id">Catégorie</label>
                <select name="categorie_id" id="categorie_id" required>
                    <?php while ($cat = $result->fetch_assoc()): ?>
                        <option value="<?= htmlspecialchars($cat['id']) ?>">
                            <?= htmlspecialchars($cat['nom']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div>
                <label for="nom">Nouveau nom</label>
                <input type="text" name="nom" id="nom" required>
            </div>

            <div>
                <label for="image">Nouvelle image</label>
                <input type="file" name="image" id="image" accept="image/*">
            </div>

            <input type="submit" value="Mettre à jour">
        </form>
    </div>
</body>
</html>
