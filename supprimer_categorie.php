<?php
require 'admin.php';
$db = Database::getInstance()->getConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    Categorie::supprimer($_POST['categorie_id']);
    echo "<div class='message success'>Catégorie supprimée avec succès.</div>";
}

$result = $db->query("SELECT * FROM categories");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer une catégorie</title>
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

        form {
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

        select {
            width: 100%;
            padding: 0.8rem;
            margin-bottom: 1.5rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 0.9rem;
            appearance: none;
            background: white url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%23333' viewBox='0 0 16 16'%3E%3Cpath d='M8 11l-4-4h8l-4 4z'/%3E%3C/svg%3E") no-repeat right 1rem center;
        }

        select:focus {
            outline: none;
            border-color: #2196F3;
        }

        input[type="submit"] {
            width: 100%;
            padding: 0.8rem;
            background-color: #f44336;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #d32f2f;
            transform: translateY(-2px);
        }

        .message {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 5px;
            text-align: center;
            font-weight: 500;
        }

        .success {
            background-color: #4CAF50;
            color: white;
        }

        .btn-back {
            display: block;
            width: fit-content;
            margin: 1rem auto;
            padding: 0.8rem 1.5rem;
            background-color: #2196F3;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            background-color: #1976D2;
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            form {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <form method="post">
            <h2>Supprimer une catégorie</h2>
            <?php if ($result->num_rows > 0): ?>
                <select name="categorie_id">
                    <?php while ($cat = $result->fetch_assoc()): ?>
                        <option value="<?= htmlspecialchars($cat['id']) ?>"><?= htmlspecialchars($cat['nom']) ?></option>
                    <?php endwhile; ?>
                </select>
                <input type="submit" value="Supprimer">
            <?php else: ?>
                <p style="text-align: center; color: #666;">Aucune catégorie disponible</p>
            <?php endif; ?>
        </form>
        <a href="index.php" class="btn-back">Retour à l'accueil</a>
    </div>
</body>
</html>