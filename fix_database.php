<?php
require_once 'Database.php';

try {
    $db = Database::getInstance()->getConnection();
    
    $result = $db->query("SHOW COLUMNS FROM categories LIKE 'image'");
    
    if ($result->num_rows == 0) {
        $sql = "ALTER TABLE categories ADD COLUMN image VARCHAR(255) AFTER nom";
        if ($db->query($sql) === TRUE) {
            echo "La colonne 'image' a été ajoutée avec succès à la table 'categories'.";
        } else {
            echo "Erreur lors de l'ajout de la colonne: " . $db->error;
        }
    } else {
        echo "La colonne 'image' existe déjà dans la table 'categories'.";
    }
} catch (Exception $e) {
    echo "Erreur: " . $e->getMessage();
}
?>