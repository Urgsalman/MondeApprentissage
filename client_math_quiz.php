<?php 
$pageTitle = "Quiz Mathématique - MondeApprentissage";
include 'client_header.php'; 
?>

<div class="math-quiz-container">
    <h1>Quiz de Mathématiques</h1>
    <p class="quiz-intro">Entraîne-toi avec des opérations mathématiques amusantes !</p>
    
    <div class="difficulty-selection">
        <h3>Choisis ton niveau :</h3>
        <div class="difficulty-buttons">
            <button class="difficulty-btn" data-level="1">Facile</button>
            <button class="difficulty-btn" data-level="2">Moyen</button>
            <button class="difficulty-btn" data-level="3">Difficile</button>
        </div>
    </div>
    
    <div class="quiz-area">
        <div class="score-display">
            <span id="correct">0</span> bonnes réponses / <span id="total">0</span> questions
        </div>
        
        <div class="operation-container">
            <div id="operation">Clique sur un niveau pour commencer</div>
            <div class="equals">=</div>
            <input type="number" id="answer" placeholder="?" disabled>
        </div>
        
        <button id="submit-btn" disabled>Vérifier</button>
        
        <div id="feedback" class="feedback"></div>
        
        <div class="mascot-container">
            <img src="uploads/mascot.png" alt="Mascotte mathématique" class="math-mascot">
        </div>
    </div>
</div>

<style>
.math-quiz-container {
    max-width: 800px;
    margin: 2rem auto;
    padding: 2rem;
    background-color: #f0f8ff;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.math-quiz-container h1 {
    color: #2196F3;
    text-align: center;
    font-size: 2.5rem;
    margin-bottom: 1rem;
}

.quiz-intro {
    text-align: center;
    font-size: 1.2rem;
    color: #555;
    margin-bottom: 2rem;
}

.difficulty-selection {
    text-align: center;
    margin-bottom: 2rem;
}

.difficulty-selection h3 {
    color: #333;
    margin-bottom: 1rem;
}

.difficulty-buttons {
    display: flex;
    justify-content: center;
    gap: 1rem;
}

.difficulty-btn {
    padding: 10px 25px;
    border: none;
    border-radius: 50px;
    background: linear-gradient(to right, #4facfe, #00f2fe);
    color: white;
    font-size: 1rem;
    font-weight: bold;
    cursor: pointer;
    transition: transform 0.2s, box-shadow 0.2s;
}

.difficulty-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(79, 172, 254, 0.4);
}

.difficulty-btn.active {
    background: linear-gradient(to right, #ff8a00, #ff5252);
    transform: scale(1.05);
}

.quiz-area {
    background-color: white;
    padding: 2rem;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    text-align: center;
    position: relative;
}

.score-display {
    font-size: 1.2rem;
    color: #666;
    margin-bottom: 2rem;
}

.operation-container {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 2rem;
    gap: 1rem;
}

#operation {
    font-size: 2.5rem;
    font-weight: bold;
    color: #333;
}

.equals {
    font-size: 2.5rem;
    font-weight: bold;
    color: #333;
}

#answer {
    width: 100px;
    height: 60px;
    font-size: 2rem;
    text-align: center;
    border: 3px solid #2196F3;
    border-radius: 10px;
    padding: 5px;
}

#answer:focus {
    outline: none;
    border-color: #ff9800;
    box-shadow: 0 0 10px rgba(255, 152, 0, 0.5);
}

#submit-btn {
    padding: 12px 35px;
    background-color: #ff9800;
    border: none;
    border-radius: 50px;
    color: white;
    font-size: 1.2rem;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-bottom: 1.5rem;
}

#submit-btn:hover {
    background-color: #f57c00;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(255, 152, 0, 0.4);
}

#submit-btn:disabled {
    background-color: #ccc;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

.feedback {
    font-size: 1.5rem;
    font-weight: bold;
    height: 40px;
    margin-bottom: 1rem;
}

.feedback.correct {
    color: #4caf50;
}

.feedback.incorrect {
    color: #f44336;
}

.mascot-container {
    position: absolute;
    right: -50px;
    bottom: -30px;
    width: 150px;
    height: 150px;
    opacity: 0.9;
}

.math-mascot {
    width: 100%;
    height: auto;
}

@keyframes jump {
    0% { transform: translateY(0); }
    50% { transform: translateY(-20px); }
    100% { transform: translateY(0); }
}

.celebrate .math-mascot {
    animation: jump 0.5s ease-in-out 2;
}

@media (max-width: 768px) {
    .math-quiz-container {
        padding: 1.5rem;
        margin: 1rem;
    }
    
    .operation-container {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .mascot-container {
        position: static;
        margin: 1rem auto;
    }
    
    .difficulty-buttons {
        flex-direction: column;
        align-items: center;
    }
    
    .difficulty-btn {
        width: 80%;
        margin-bottom: 0.5rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const operationEl = document.getElementById('operation');
    const answerEl = document.getElementById('answer');
    const submitBtn = document.getElementById('submit-btn');
    const feedbackEl = document.getElementById('feedback');
    const correctEl = document.getElementById('correct');
    const totalEl = document.getElementById('total');
    const difficultyBtns = document.querySelectorAll('.difficulty-btn');
    const mascotContainer = document.querySelector('.mascot-container');
    
    let currentAnswer = 0;
    let correctCount = 0;
    let totalCount = 0;
    let currentLevel = 0;
    
    // Attach listeners to difficulty buttons
    difficultyBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Remove active class from all buttons
            difficultyBtns.forEach(b => b.classList.remove('active'));
            
            // Add active class to clicked button
            this.classList.add('active');
            
            // Set current level
            currentLevel = parseInt(this.dataset.level);
            
            // Enable answer input
            answerEl.disabled = false;
            answerEl.focus();
            
            // Enable submit button
            submitBtn.disabled = false;
            
            // Generate new question
            generateQuestion();
        });
    });
    
    // Submit answer on button click
    submitBtn.addEventListener('click', checkAnswer);
    
    // Also submit on Enter key
    answerEl.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            checkAnswer();
        }
    });
    
    function generateQuestion() {
        // Clear previous feedback
        feedbackEl.textContent = '';
        feedbackEl.className = 'feedback';
        
        let num1, num2, operator;
        
        // Generate numbers based on difficulty
        switch(currentLevel) {
            case 1: // Easy
                num1 = Math.floor(Math.random() * 10) + 1;
                num2 = Math.floor(Math.random() * 10) + 1;
                operator = Math.random() < 0.7 ? '+' : '-';
                
                // Make sure subtraction doesn't result in negative number for level 1
                if (operator === '-' && num2 > num1) {
                    [num1, num2] = [num2, num1];
                }
                break;
                
            case 2: // Medium
                num1 = Math.floor(Math.random() * 20) + 1;
                num2 = Math.floor(Math.random() * 20) + 1;
                
                // More varied operations
                const opChoice = Math.random();
                if (opChoice < 0.4) {
                    operator = '+';
                } else if (opChoice < 0.8) {
                    operator = '-';
                    // Make sure subtraction doesn't result in negative number
                    if (num2 > num1) {
                        [num1, num2] = [num2, num1];
                    }
                } else {
                    operator = '×';
                    // Make multiplication easier
                    num2 = Math.floor(Math.random() * 5) + 1;
                }
                break;
                
            case 3: // Hard
                num1 = Math.floor(Math.random() * 50) + 10;
                num2 = Math.floor(Math.random() * 30) + 5;
                
                // More complex operations
                const opChoice2 = Math.random();
                if (opChoice2 < 0.25) {
                    operator = '+';
                } else if (opChoice2 < 0.5) {
                    operator = '-';
                    // Make sure subtraction doesn't result in negative number
                    if (num2 > num1) {
                        [num1, num2] = [num2, num1];
                    }
                } else if (opChoice2 < 0.8) {
                    operator = '×';
                    // Make multiplication manageable
                    num2 = Math.floor(Math.random() * 10) + 2;
                } else {
                    operator = '÷';
                    // Ensure division results in a whole number
                    num2 = Math.floor(Math.random() * 10) + 1;
                    num1 = num2 * (Math.floor(Math.random() * 10) + 1);
                }
                break;
        }
        
        // Calculate the correct answer
        switch(operator) {
            case '+': currentAnswer = num1 + num2; break;
            case '-': currentAnswer = num1 - num2; break;
            case '×': currentAnswer = num1 * num2; break;
            case '÷': currentAnswer = num1 / num2; break;
        }
        
        // Display the operation
        operationEl.textContent = `${num1} ${operator} ${num2}`;
        
        // Clear the answer input
        answerEl.value = '';
        answerEl.focus();
    }
    
    function checkAnswer() {
        // Get user's answer
        const userAnswer = parseInt(answerEl.value);
        
        // Check if answer is empty
        if (isNaN(userAnswer)) {
            feedbackEl.textContent = 'Entre un nombre !';
            feedbackEl.className = 'feedback incorrect';
            return;
        }
        
        // Increment total count
        totalCount++;
        totalEl.textContent = totalCount;
        
        // Check if answer is correct
        if (userAnswer === currentAnswer) {
            // Increment correct count
            correctCount++;
            correctEl.textContent = correctCount;
            
            // Show positive feedback
            feedbackEl.textContent = 'Bonne réponse ! 🎉';
            feedbackEl.className = 'feedback correct';
            
            // Celebrate
            mascotContainer.classList.add('celebrate');
            setTimeout(() => {
                mascotContainer.classList.remove('celebrate');
            }, 1000);
        } else {
            // Show negative feedback
            feedbackEl.textContent = `Non, la réponse était ${currentAnswer}`;
            feedbackEl.className = 'feedback incorrect';
        }
        
        // Generate new question after a short delay
        setTimeout(generateQuestion, 1500);
    }
});
</script>

<?php include 'client_footer.php'; ?>