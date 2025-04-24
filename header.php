<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
    header("Location: admin_interface.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Kids Learnings</title>
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
        }

        .admin-header {
            background-color: #2196F3;
            color: white;
            padding: 1.5rem 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .container {
            width: 95%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .admin-header h1 {
            font-size: 1.5rem;
            font-weight: 600;
        }

        .admin-nav {
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .nav-links {
            list-style: none;
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            padding: 1rem 0;
        }

        .nav-links a {
            color: #333;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .nav-links a:hover {
            background-color: #2196F3;
            color: white;
        }

        .admin-content {
            padding: 2rem 0;
        }

        @media (max-width: 768px) {
            .nav-links {
                flex-direction: column;
                padding: 0.5rem 0;
            }

            .nav-links li {
                width: 100%;
            }

            .nav-links a {
                display: block;
                padding: 0.8rem 1rem;
                border-radius: 0;
            }

            .admin-header h1 {
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>
    <header class="admin-header">
        <div class="container">
            <h1>Kids Learnings - Administration</h1>
        </div>
    </header>
    
    <nav class="admin-nav">
        <div class="container">
            <ul class="nav-links">
                <li><a href="admin_interface.php">Accueil Admin</a></li>
                <li><a href="afficher.php">Afficher Médias</a></li>
                <li><a href="admin_insert.php">Ajouter Contenu</a></li>
                <li><a href="admin_delete.php">Supprimer Contenu</a></li> 
                <li><a href="modifier_element.php">Modifier Élément</a></li>
                <li><a href="modifier_categorie.php">Modifier Catégorie</a></li>
                <li><a href="admin_interface.php?logout=1">Déconnexion</a></li>
            </ul>
        </div>
    </nav>
    
    <div class="container">
        <div class="admin-content">