<?php
session_start();
require 'admin.php';

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}

if (isset($_POST['login'])) {
    if ($_POST['username'] === 'admin' && $_POST['password'] === 'admin') {
        $_SESSION['logged_in'] = true;
        header("Location: index.php");
        exit;
    } else {
        $error = "Nom d'utilisateur ou mot de passe incorrect";
    }
}

if (!isset($_SESSION['logged_in'])) {
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - Kids Learnings</title>
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
            padding: 2rem;
        }

        .login-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 2rem;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        }

        .login-title {
            text-align: center;
            margin-bottom: 2rem;
            color: #333;
            font-weight: 600;
        }

        .error-message {
            background-color: #fee;
            color: #d63031;
            padding: 0.8rem;
            border-radius: 5px;
            margin-bottom: 1rem;
            text-align: center;
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
        input[type="password"] {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #2196F3;
            box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.1);
        }

        .btn {
            width: 100%;
            padding: 0.8rem;
            background-color: #2196F3;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            transition: all 0.3s ease;
        }

        .btn:hover {
            background-color: #1976D2;
            transform: translateY(-2px);
        }

        h1 {
            text-align: center;
            color: #333;
            margin: 2rem 0;
            font-weight: 600;
        }

        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
            padding: 1rem;
        }

        .card {
            background-color: white;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .card h3 {
            color: #2196F3;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .card p {
            color: #666;
            margin-bottom: 1.5rem;
            line-height: 1.5;
        }

        .card .btn {
            background-color: #2196F3;
            margin-top: auto;
        }

        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }
            
            .dashboard-cards {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
            
            .card {
                padding: 1.2rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2 class="login-title">Connexion Administration</h2>
        
        <?php if (isset($error)): ?>
            <div class="error-message"><?= $error ?></div>
        <?php endif; ?>
        
        <form method="post">
            <div>
                <label for="username">Nom d'utilisateur :</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div>
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <input type="submit" name="login" value="Se connecter" class="btn">
        </form>
    </div>
</body>
</html>
<?php
    exit;
}

include 'header.php';
?>

<h1>Tableau de bord - Administration</h1>

<div class="dashboard-cards">
    <div class="card">
        <h3>Gestion des médias</h3>
        <p>Visualisez et gérez tous les fichiers médias.</p>
        <a href="afficher.php" class="btn">Gérer les médias</a>
    </div>
    
    <div class="card">
        <h3>Ajouter du contenu</h3>
        <p>Ajoutez de nouvelles catégories, éléments ou fichiers médias.</p>
        <a href="admin_insert.php" class="btn">Ajouter du contenu</a>
    </div>
    
    <div class="card">
        <h3>Supprimer du contenu</h3>
        <p>Supprimez des catégories, éléments ou fichiers médias existants.</p>
        <a href="admin_delete.php" class="btn">Supprimer du contenu</a>
    </div>
    
    <div class="card">
        <h3>Modifier des éléments</h3>
        <p>Mettez à jour les informations des éléments.</p>
        <a href="modifier_element.php" class="btn">Modifier des éléments</a>
    </div>
    
    <div class="card">
        <h3>Modifier des catégories</h3>
        <p>Mettez à jour les informations des catégories.</p>
        <a href="modifier_categorie.php" class="btn">Modifier des catégories</a>
    </div>
</div>

<style>
.dashboard-cards {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
    margin-top: 30px;
}

.card {
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    padding: 20px;
    border-radius: 4px;
}

.card h3 {
    margin-top: 0;
    color: #444;
}

.card .btn {
    margin-top: 15px;
}

@media (max-width: 600px) {
    .dashboard-cards {
        grid-template-columns: 1fr;
    }
}
</style>

<?php include 'footer.php'; ?>