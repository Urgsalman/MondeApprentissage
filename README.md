

# 🌟 Site Dynamique d'Apprentissage des Enfants

## 📚 Sujet
Développement d'un site web interactif pour l'apprentissage des enfants.

## 👨‍💻 Réalisé par
[@zkhribach](https://github.com/zkhribach) (Ziyad KHRIBACH)
[@Urgsalman](https://github.com/Urgsalman) (Cherif Soulaimane)
[@ZakL25](https://github.com/ZakL25) (Zakaria Abde Laabid)
[@saadoooox](https://github.com/saadoooox) (Aissi Saad)

---

## 🎬 Vidéo Présentation

### Voici ci-joint un lien OneDrive vers la video présentation 
https://esiac-my.sharepoint.com/:v:/g/personal/zakaria-abderrahmane_laabid_esi_ac_ma/EcQBWWA8535LqP-fEvoGOP8BenU4kfwwzMx-NP2Vp3_W8g

---

## 📋 Fonctionnalités

### 🛠 Côté Administrateur
- Gestion de la base de données **MySQL**.
- Ajout, modification et suppression de :
  - **Catégories** (ex : Animaux, Moyens de transport, etc.)
  - **Éléments** (Textes descriptifs associés aux catégories)
  - **Images**
  - **Audios**
  - **Vidéos**
  
### 👀 Côté Client
- Affichage public de toutes les catégories, éléments, images, audios et vidéos.
- Lecture de médias associés aux éléments.

---

## ⚙️ Installation

1. Clonez ou téléchargez ce dépôt.
2. Placez tous les fichiers du projet dans le dossier `htdocs` de votre serveur local XAMPP.
3. **Important :**
   - Le dossier **`data`** doit être copié dans le dossier **`mysql`** (habituellement situé dans `xampp/mysql/`).
   - Cela permet d'avoir la base de données correctement restaurée pour utiliser le projet.
4. Assurez-vous que le dossier **`uploads`** existe et contient vos médias (images, audios, vidéos).
5. Lancez **Apache** et **MySQL** depuis le panneau de contrôle XAMPP.
6. Importez la base de données si nécessaire à partir du fichier `fix_database.php` (prévu pour corriger ou initialiser la structure).
7. Accédez au projet via [http://localhost/nom_du_projet](http://localhost/nom_du_projet).

---

## 📂 Structure du projet

Partie Client

-**index.php :** Page d'accueil du site
-**client_header.php :** En-tête des pages client
-**client_footer.php- :** Pied de page des pages client
-**client_categories.php- :** Affichage des catégories pour les utilisateurs
-**client_elements.php- :** Affichage des éléments et médias associés
-**client_quiz.php- :** Quiz généré à partir des catégories
-**client_quiz_result.php- :** Affichage des résultats de quiz
-**client_math_quiz.php- :** Quiz spécifique aux mathématiques
-**client_media.php- :** Gestion de l'affichage des médias

Partie Administration

-**admin.php- :** Page principale d'administration
-**admin_interface.php- :** Interface de connexion et d'administration
-**admin_insert.php- :** Insertion de données
-**admin_delete.php- :** Suppression de données
-**modifier.php- :** Interface générale de modification
-**modifier_categorie.php- :** Modification des catégories
-**modifier_element.php- :** Modification des éléments
-**traitement.php- :** Traitement des données soumises

Utilitaires

-**Database.php- :** Gestion de la connexion à la base de données
-**fix_database.php- :** Réparation de la base de données
-**helper.php- :** Fonctions d'aide diverses
-**afficher.php- :** Fonctions d'affichage génériques
-**install.php- :** Script d'installation de l'application

Ressources

-**uploads/ :** Contient les médias (images, audios, vidéos)
-**data/ :** Dossier à copier dans mysql pour restaurer la base de données
-**css/ :** Fichiers de style (dont style_admin.css)
-**js/ :** Scripts JavaScript

---

## 🔥 Bonus
- LARAVEL n'a pas été utilisé dans ce project.

---

## ✅ Notes
- Vous pouvez créer des administrateurs via database phpmyadmin.

