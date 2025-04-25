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
    
    // Animation sur les cartes d'éléments
    const elementCards = document.querySelectorAll('.element-card');
    
    elementCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px) scale(1.02)';
            this.style.boxShadow = '0 8px 20px rgba(0,0,0,0.15)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = '';
            this.style.boxShadow = '';
        });
    });
    
    // Gestion des boutons audio et vidéo sur la page d'accueil
    const audioButtons = document.querySelectorAll('.audio-btn');
    const videoButtons = document.querySelectorAll('.video-btn');
    
    audioButtons.forEach(button => {
        button.addEventListener('click', function() {
            const audioSrc = this.getAttribute('data-audio');
            if (audioSrc) {
                // Créer un élément audio temporaire et le jouer
                const audio = new Audio(audioSrc);
                audio.play();
            } else {
                alert('Fichier audio non disponible');
            }
        });
    });
    
    videoButtons.forEach(button => {
        button.addEventListener('click', function() {
            const videoSrc = this.getAttribute('data-video');
            if (videoSrc) {
                // Créer une modal pour afficher la vidéo
                const modal = document.createElement('div');
                modal.className = 'video-modal';
                modal.innerHTML = `
                    <div class="video-modal-content">
                        <span class="close-modal">&times;</span>
                        <video controls width="100%" autoplay>
                            <source src="${videoSrc}" type="video/mp4">
                            Votre navigateur ne supporte pas la vidéo.
                        </video>
                    </div>
                `;
                document.body.appendChild(modal);
                
                // Fermer la modal au clic sur le X
                modal.querySelector('.close-modal').addEventListener('click', function() {
                    document.body.removeChild(modal);
                });
                
                // Fermer la modal au clic à l'extérieur
                modal.addEventListener('click', function(e) {
                    if (e.target === modal) {
                        document.body.removeChild(modal);
                    }
                });
            } else {
                alert('Fichier vidéo non disponible');
            }
        });
    });
    
    // Ajouter les styles pour la modal vidéo si pas déjà présents
    if (!document.getElementById('video-modal-styles')) {
        const style = document.createElement('style');
        style.id = 'video-modal-styles';
        style.textContent = `
            .video-modal {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0,0,0,0.8);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 1000;
            }
            .video-modal-content {
                position: relative;
                width: 80%;
                max-width: 800px;
                background-color: #fff;
                padding: 20px;
                border-radius: 10px;
            }
            .close-modal {
                position: absolute;
                top: 10px;
                right: 10px;
                font-size: 24px;
                cursor: pointer;
                color: #333;
            }
        `;
        document.head.appendChild(style);
    }
});