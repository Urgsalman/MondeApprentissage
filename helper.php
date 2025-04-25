<?php
/**
 * Fichier de fonctions utilitaires pour l'application MondeApprentissage
 */

/**
 * Formate une chaîne de texte pour l'affichage sécurisé
 * 
 * @param string $text Texte à formater
 * @return string Texte formaté
 */
function formatText($text) {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

/**
 * Tronque un texte à une longueur spécifique
 * 
 * @param string $text Texte à tronquer
 * @param int $length Longueur maximale
 * @param string $suffix Suffixe à ajouter (par défaut "...")
 * @return string Texte tronqué
 */
function truncateText($text, $length = 100, $suffix = '...') {
    if (mb_strlen($text) <= $length) {
        return $text;
    }
    return mb_substr($text, 0, $length) . $suffix;
}

/**
 * Détermine si un élément est actif dans la navigation
 * 
 * @param string $pageName Nom de la page à vérifier
 * @return bool True si la page est active
 */
function isActivePage($pageName) {
    $currentPage = basename($_SERVER['PHP_SELF']);
    return $currentPage === $pageName;
}

/**
 * Construit une URL propre
 * 
 * @param string $path Chemin relatif
 * @param array $params Paramètres à ajouter
 * @return string URL formatée
 */
function buildUrl($path, $params = []) {
    $url = $path;
    if (!empty($params)) {
        $url .= '?' . http_build_query($params);
    }
    return $url;
}

/**
 * Vérifie si un élément existe dans une catégorie
 * 
 * @param int $categoryId ID de la catégorie
 * @param object $conn Connexion à la base de données
 * @return int Nombre d'éléments
 */
function countElementsInCategory($categoryId, $conn) {
    $query = "SELECT COUNT(*) as count FROM elements WHERE categorie_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $categoryId);
    $stmt->execute();
    $result = $stmt->get_result();
    $count = $result->fetch_assoc();
    return $count['count'];
}

/**
 * Récupère les médias associés à un élément
 * 
 * @param int $elementId ID de l'élément
 * @param object $conn Connexion à la base de données
 * @return array Tableau des médias groupés par type
 */
function getElementMedias($elementId, $conn) {
    $medias = [
        'image' => [],
        'audio' => [],
        'video' => []
    ];
    
    $query = "SELECT * FROM medias WHERE element_id = ? ORDER BY date_creation";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $elementId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($media = $result->fetch_assoc()) {
        $type = $media['typee'];
        $medias[$type][] = $media;
    }
    
    return $medias;
}

/**
 * Enregistre les données de visites
 * 
 * @param string $page Page visitée
 * @param int $itemId ID de l'élément visité (optionnel)
 */
function logPageVisit($page, $itemId = null) {
    // On pourrait implémenter un système de suivi des visites ici
    // pour des statistiques d'utilisation
}