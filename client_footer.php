</div>

<footer class="site-footer">
    <div class="footer-content">
        <div class="footer-creators">
            <p>Créé par :</p>
            <ul class="creator-list">
                <li>Zakaria Abde Laabid</li>
                <li>Ziyad Khribach</li>
                <li>Cherif Soulaimane</li>
                <li>Aissi Saad</li>
            </ul>
        </div>
        <div class="footer-copyright">
            <p>&copy; <?php echo date('Y'); ?> MondeApprentissage - Tous droits réservés</p>
        </div>
    </div>
</footer>

<style>
.site-footer {
    background-color: #2c3e50;
    color: #ecf0f1;
    padding: 20px 0;
    font-family: 'Poppins', sans-serif;
}

.footer-content {
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    padding: 0 20px;
}

.footer-creators {
    margin-bottom: 15px;
}

.footer-creators p {
    font-weight: 600;
    margin-bottom: 8px;
    color: #bdc3c7;
}

.creator-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 15px;
}

.creator-list li {
    font-size: 0.95rem;
    color: #ecf0f1;
}

.footer-copyright {
    font-size: 0.9rem;
    color: #bdc3c7;
    border-top: 1px solid rgba(255,255,255,0.1);
    padding-top: 15px;
    width: 100%;
}

@media (max-width: 600px) {
    .creator-list {
        flex-direction: column;
        gap: 5px;
    }
}
</style>
</body>
</html>