document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    const primaryNav = document.querySelector('.primary-nav');
    const adminAccess = document.querySelector('.admin-access');
    
    mobileMenuToggle.addEventListener('click', function() {
        // Toggle menu
        primaryNav.style.display = primaryNav.style.display === 'block' ? 'none' : 'block';
        adminAccess.style.display = adminAccess.style.display === 'block' ? 'none' : 'block';
        
        // Animation hamburger
        this.classList.toggle('active');
    });
    
    // Gestion du resize
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            primaryNav.style.display = '';
            adminAccess.style.display = '';
            mobileMenuToggle.classList.remove('active');
        }
    });
});