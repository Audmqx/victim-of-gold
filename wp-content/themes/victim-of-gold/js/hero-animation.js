document.addEventListener('DOMContentLoaded', function() {
    const header = document.querySelector('header');
    let lastScrollTop = 0;
    const scrollThreshold = 100; // Seuil de défilement en pixels

    window.addEventListener('scroll', function() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        // Détermine la direction du scroll
        if (scrollTop > lastScrollTop && scrollTop > scrollThreshold) {
            // Scroll vers le bas - cache le header
            header.style.transform = 'translateY(-100%)';
        } else {
            // Scroll vers le haut - montre le header
            header.style.transform = 'translateY(0)';
        }
        
        lastScrollTop = scrollTop;
    });
}); 