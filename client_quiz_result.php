<?php
error_reporting(E_ERROR);
require_once 'Database.php';
$db = Database::getInstance();
$conn = $db->getConnection();

$element_id = intval($_POST['element_id']);
$media_id = intval($_POST['media_id']);

// Vérifie si ce média est bien lié à l'élément
$stmt = $conn->prepare("SELECT * FROM medias WHERE id = ? AND element_id = ?");
$stmt->bind_param("ii", $media_id, $element_id);
$stmt->execute();
$correct = $stmt->get_result()->num_rows > 0;

include 'client_header.php';
?>
<div class="page-container">
    <div class="quiz-result">
        <h2><?= $correct ? "✅ Bravo ! Bonne réponse !" : "❌ Oups, mauvaise réponse !" ?></h2>
        <p><?= $correct ? " " : " " ?></p>
        <a href="client_quiz.php" class="btn-quiz">Refaire un quiz</a>
    </div>
</div>

<?php include 'client_footer.php'; ?>