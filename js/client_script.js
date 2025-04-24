// Attendre que le DOM soit chargé
document.addEventListener('DOMContentLoaded', function() {
    // Animation sur les cartes de catégories
    const categoryCards = document.querySelectorAll('.category-card');
    
    categoryCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px) scale(1.03)';
            this.style.boxShadow = '0 10px 20px rgba(0,0,0,0.2)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = '';
            this.style.boxShadow = '';
        });
    });
    
    // Gestion des boutons audio et vidéo
    const audioButtons = document.querySelectorAll('.audio-btn');
    const videoButtons = document.querySelectorAll('.video-btn');
    
    audioButtons.forEach(button => {
        button.addEventListener('click', function() {
            alert('Fonctionnalité audio: À implémenter');
            // Ici vous implémenteriez la lecture audio
        });
    });
    
    videoButtons.forEach(button => {
        button.addEventListener('click', function() {
            alert('Fonctionnalité vidéo: À implémenter');
            // Ici vous implémenteriez la lecture vidéo
        });
    });
});