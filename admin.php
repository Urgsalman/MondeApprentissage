<?php
require 'Database.php';
error_reporting(E_ERROR);

class Administrateur {
	public $nom_utilisateur;
	public $mot_de_passe;
	public $email;
	
	public function __construct($nom_utilisateur, $mot_de_passe, $email) {
		$this->nom_utilisateur = $nom_utilisateur;
		$this->mot_de_passe = $mot_de_passe;
		$this->email = $email;
	}

	public function inserer() {
		$db = Database::getInstance();
		$connexion = $db->getConnection();
		$sql = "INSERT INTO administrateurs (nom_utilisateur, mot_de_passe, email)
		        VALUES ('$this->nom_utilisateur', '$this->mot_de_passe', '$this->email')";
		$connexion->query($sql);
	}

	public static function supprimer($nom_utilisateur, $mot_de_passe) {
		$db = Database::getInstance();
		$connexion = $db->getConnection();
		$sql = "DELETE FROM administrateurs WHERE nom_utilisateur = '$nom_utilisateur' AND mot_de_passe = '$mot_de_passe'";
		$connexion->query($sql);
		echo "supprimé $nom_utilisateur<br>";
	}

	public function miseajour($nouveau_mot_de_passe = "", $nouvel_email = "") {
		$db = Database::getInstance();
		$connexion = $db->getConnection();

		if ($nouveau_mot_de_passe != "") {
			$sql = "UPDATE administrateurs SET mot_de_passe = '$nouveau_mot_de_passe' WHERE nom_utilisateur = '$this->nom_utilisateur'";
			$connexion->query($sql);
			echo "mot_de_passe mis à jour<br>";
		}
		if ($nouvel_email != "") {
			$sql = "UPDATE administrateurs SET email = '$nouvel_email' WHERE nom_utilisateur = '$this->nom_utilisateur'";
			$connexion->query($sql);
			echo "email mis à jour<br>";
		}
	}
}

class Categorie {
        public $id;
        public $nom;
        public $image;
    
        public function __construct($nom, $image = null) {
            $this->nom = $nom;
            $this->image = $image;
        }
    
        public function inserer() {
            $db = Database::getInstance()->getConnection();
            
            // Vérifier si la colonne 'image' existe
            $result = $db->query("SHOW COLUMNS FROM categories LIKE 'image'");
            
            if ($result->num_rows > 0) {
                // La colonne existe, insérer avec l'image
                $sql = "INSERT INTO categories (nom, image) VALUES ('$this->nom', '$this->image')";
            } else {
                // La colonne n'existe pas, insérer sans l'image
                $sql = "INSERT INTO categories (nom) VALUES ('$this->nom')";
            }
            
            if (!$db->query($sql)) {
                echo "Erreur MySQL: " . $db->error;
            }
        }

	public static function supprimer($id) {
		$db = Database::getInstance()->getConnection();
		$db->query("DELETE FROM categories WHERE id = $id");
	}

	public function miseajour($id) {
		$db = Database::getInstance()->getConnection();
		$db->query("UPDATE categories SET nom = '$this->nom', image = '$this->image' WHERE id = $id");
	}

	
}

class Element {
	public $categorie_id;
	public $titre;
	public $description;

	public function __construct($categorie_id, $titre, $description = null) {
		$this->categorie_id = $categorie_id;
		$this->titre = $titre;
		$this->description = $description;
	}

	public function inserer() {
		$db = Database::getInstance()->getConnection();
		$sql = "INSERT INTO elements (categorie_id, titre, description) VALUES ($this->categorie_id, '$this->titre', '$this->description')";
		$db->query($sql);
	}

	public static function supprimer($id) {
		$db = Database::getInstance()->getConnection();
		$db->query("DELETE FROM elements WHERE id = $id");
	}


    public function miseajour($id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("UPDATE elements SET 
            categorie_id = ?, 
            titre = ?, 
            description = ? 
            WHERE id = ?");
        
        $stmt->bind_param("issi", 
            $this->categorie_id,
            $this->titre,
            $this->description,
            $id
        );

        return $stmt->execute();
	}
	
}

class Media {
    public $element_id;
    public $typee;
    public $chemin_fichier;
    public $titre;

    public function __construct($element_id, $typee, $chemin_fichier, $titre = null) {
        $this->element_id = $element_id;
        $this->typee = $typee;
        $this->chemin_fichier = $chemin_fichier;
        $this->titre = $titre;
    }

    public function inserer() {
        $db = Database::getInstance()->getConnection();
        $sql = "INSERT INTO medias (element_id, typee, chemin_fichier, titre) 
                VALUES ($this->element_id, '$this->typee', '$this->chemin_fichier', '$this->titre')";
        $db->query($sql);
    }

    public static function supprimer($id) {
        $db = Database::getInstance()->getConnection();
        $db->query("DELETE FROM medias WHERE id = $id");
    }

    public function miseajour($id) {
        $db = Database::getInstance()->getConnection();
        $sql = "UPDATE medias 
                SET element_id = $this->element_id,
                    typee = '$this->typee', 
                    chemin_fichier = '$this->chemin_fichier', 
                    titre = '$this->titre' 
                WHERE id = $id";
        if (!$db->query($sql)) {
            echo "Erreur MySQL : " . $db->error;
        }
    }

    public static function afficherComplet() {
        $db = Database::getInstance()->getConnection();
        $sql = "
            SELECT 
                m.id AS media_id,
                m.titre AS media_titre,
                m.typee,
                m.chemin_fichier,
                e.id AS element_id,
                e.titre AS element_titre,
                e.description,
                c.id AS categorie_id,
                c.nom AS categorie_nom,
                c.image AS categorie_image,
                m.date_creation
            FROM medias m
            JOIN elements e ON m.element_id = e.id
            JOIN categories c ON e.categorie_id = c.id
            ORDER BY m.date_creation DESC
        ";
        $result = $db->query($sql);
        
        while ($row = $result->fetch_object()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row->media_id) . "</td>";
            echo "<td>" . htmlspecialchars($row->media_titre) . "</td>";
            echo "<td>" . htmlspecialchars($row->typee) . "</td>";
            echo "<td>";
            if ($row->typee === 'image') {
                echo "<img src='uploads/" . htmlspecialchars($row->chemin_fichier) . "' width='50' height='50' alt='Media Image'>";
            } else {
                echo "<a href='uploads/" . htmlspecialchars($row->chemin_fichier) . "' target='_blank'>Voir</a>";
            }
            echo "</td>";
            echo "<td>" . htmlspecialchars($row->element_titre) . "</td>";
            echo "<td>" . htmlspecialchars($row->description) . "</td>";
            echo "<td>" . htmlspecialchars($row->categorie_nom) . "</td>";
            echo "<td>";
            if ($row->categorie_image) {
                echo "<img src='uploads/" . htmlspecialchars($row->categorie_image) . "' width='50' height='50' alt='Category Image'>";
            }
            echo "</td>";
            echo "<td>" . htmlspecialchars($row->date_creation) . "</td>";
            echo "</tr>";
        }
    }
}
?>
