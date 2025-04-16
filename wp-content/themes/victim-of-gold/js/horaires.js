document.addEventListener('DOMContentLoaded', function() {
    const today = new Date().getDay(); // 0 = Dimanche, 1 = Lundi, etc.
    const horaires = document.querySelectorAll('.horaire-item');
    
    // Trouve l'élément correspondant au jour actuel
    const todayElement = document.querySelector(`.horaire-item[data-day="${today}"]`);
    
    if (todayElement) {
        // Ajoute la classe today
        todayElement.classList.add('today');
        
        // Ajoute la classe active après un court délai pour déclencher l'animation
        setTimeout(() => {
            todayElement.classList.add('active');
        }, 100);
    }
}); 