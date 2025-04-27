<?php
error_reporting(E_ERROR);
require_once 'Database.php';
$db = Database::getInstance();
$conn = $db->getConnection();

$pageTitle = "Quiz d'apprentissage";
include 'client_header.php';
?>

<div class="quiz-container">
    <?php if (!isset($_GET['categorie_id'])): ?>
        <div class="quiz-categories">
            <h1 class="quiz-title">Sélectionnez une catégorie</h1>
            <div class="categories-grid">
                <?php
                $result = $conn->query("SELECT * FROM categories ORDER BY nom");
                while ($cat = $result->fetch_assoc()):
                ?>
                    <div class="category-card" style="--delay: <?= $loop * 0.1 ?>s">
                        <div class="card-inner">
                            <?php if (!empty($cat['image'])): ?>
                                <img src="uploads/<?= htmlspecialchars($cat['image']) ?>" 
                                     alt="<?= htmlspecialchars($cat['nom']) ?>">
                            <?php else: ?>
                                <div class="category-icon"><?= substr($cat['nom'], 0, 1) ?></div>
                            <?php endif; ?>
                            <h3><?= htmlspecialchars($cat['nom']) ?></h3>
                            <a href="client_quiz.php?categorie_id=<?= $cat['id'] ?>" class="quiz-btn">
                                Commencer le quiz
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    <?php else: 
    $categorie_id = intval($_GET['categorie_id']);
    $stmt = $conn->prepare("SELECT * FROM elements WHERE categorie_id = ? ORDER BY RAND() LIMIT 1");
    $stmt->bind_param("i", $categorie_id);
    $stmt->execute();
    $element = $stmt->get_result()->fetch_assoc();

    if (!$element): ?>
        <div class="empty-state">
            <h2>Oops! Pas encore d'éléments ici! </h2>
            <p>Reviens bientôt pour découvrir de nouveaux quiz!</p>
            <a href="client_quiz.php" class="quiz-btn">Retour aux catégories</a>
        </div>
    <?php 
    exit;
    endif;
    $stmt = $conn->prepare("SELECT * FROM medias WHERE element_id = ? ORDER BY RAND() LIMIT 1");
    $stmt->bind_param("i", $element['id']);
    $stmt->execute();
    $good_media = $stmt->get_result()->fetch_assoc();

    // Get decoy media
    $stmt = $conn->prepare("SELECT * FROM medias WHERE element_id != ? ORDER BY RAND() LIMIT 2");
    $stmt->bind_param("i", $element['id']);
    $stmt->execute();
    $fake_medias = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    // Build quiz options
    $options = array_merge([$good_media], $fake_medias);
    shuffle($options);
    ?>
    ?>
        <div class="quiz-question">
            <div class="question-header">
                <h2>Question : Identifiez le média correspondant à 
                    <span class="highlight"><?= htmlspecialchars($element['titre']) ?></span>
                </h2>
            </div>

            <form method="post" action="client_quiz_result.php" class="quiz-form">
                <input type="hidden" name="element_id" value="<?= $element['id'] ?>">
                
                <div class="quiz-options">
                    <?php foreach ($options as $index => $media): ?>
                        <label class="quiz-option">
                            <input type="radio" name="media_id" value="<?= $media['id'] ?>" required>
                            <div class="option-content">
                                <span class="option-number"><?= $index + 1 ?></span>
                                <?php if ($media['typee'] === 'image'): ?>
                                    <img src="uploads/<?= htmlspecialchars($media['chemin_fichier']) ?>" 
                                         alt="Option <?= $index + 1 ?>">
                                <?php elseif ($media['typee'] === 'audio'): ?>
                                    <div class="audio-player">
                                        <audio controls>
                                            <source src="uploads/<?= htmlspecialchars($media['chemin_fichier']) ?>" 
                                                    type="audio/mpeg">
                                        </audio>
                                    </div>
                                <?php elseif ($media['typee'] === 'video'): ?>
                                    <div class="video-player">
                                        <video controls width="100%">
                                            <source src="uploads/<?= htmlspecialchars($media['chemin_fichier']) ?>" 
                                                    type="video/mp4">
                                        </video>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </label>
                    <?php endforeach; ?>
                </div>

                <div class="button-group">
                    <button type="submit" class="submit-btn">Valider</button>
                    <a href="client_quiz.php" class="back-btn">Retour aux catégories</a>
                </div>
            </form>
        </div>
    <?php endif; ?>
</div>

<style>
.quiz-container {
    max-width: 1200px;
    margin: 2rem auto;
    padding: 20px;
}

.quiz-title {
    text-align: center;
    color: #2C3E50;
    font-size: 2.2rem;
    margin-bottom: 2rem;
    font-weight: 600;
}

.categories-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 2rem;
    padding: 1rem;
}

.category-card {
    background: white;
    border-radius: 8px;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.card-inner {
    padding: 1.5rem;
    text-align: center;
}

.card-inner img {
    width: 140px;
    height: 140px;
    object-fit: cover;
    border-radius: 8px;
    margin-bottom: 1rem;
}

.card-inner h3 {
    color: #2C3E50;
    margin-bottom: 1.2rem;
    font-size: 1.3rem;
    font-weight: 600;
}

.quiz-btn,
.submit-btn,
.back-btn {
    display: inline-block;
    padding: 0.8rem 1.6rem;
    background: #3498DB;
    color: white;
    text-decoration: none;
    border-radius: 6px;
    font-weight: 500;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    font-size: 1rem;
}

.quiz-btn:hover,
.submit-btn:hover {
    background: #2980B9;
    transform: translateY(-2px);
}

.back-btn {
    background: #95A5A6;
    margin-left: 1rem;
}

.back-btn:hover {
    background: #7F8C8D;
}

.quiz-question {
    background: white;
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.question-header {
    margin-bottom: 2rem;
}

.question-header h2 {
    color: #2C3E50;
    font-size: 1.5rem;
    font-weight: 600;
}

.highlight {
    color: #3498DB;
    font-weight: 600;
}

.quiz-options {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin: 2rem 0;
}

.quiz-option {
    cursor: pointer;
    position: relative;
}

.option-content {
    padding: 1rem;
    border: 2px solid #E5E7E9;
    border-radius: 6px;
    transition: all 0.3s ease;
}

.quiz-option:hover .option-content {
    border-color: #3498DB;
}

.option-number {
    position: absolute;
    top: -8px;
    left: -8px;
    background: #3498DB;
    color: white;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 500;
    font-size: 0.9rem;
    z-index: 1;
}

.button-group {
    display: flex;
    justify-content: center;
    gap: 1rem;
    margin-top: 2rem;
}

@media (max-width: 768px) {
    .quiz-options {
        grid-template-columns: 1fr;
    }
    
    .quiz-title {
        font-size: 1.8rem;
    }
    
    .button-group {
        flex-direction: column;
        gap: 1rem;
    }
    
    .back-btn {
        margin-left: 0;
    }
}
</style>

<?php include 'client_footer.php'; ?>