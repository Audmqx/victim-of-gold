document.addEventListener('DOMContentLoaded', function() {
    // Vérifie si GSAP est déjà chargé
    if (typeof gsap === 'undefined') {
        console.error('GSAP n\'est pas chargé. Veuillez ajouter GSAP à votre projet.');
        return;
    }

    const svg = document.querySelector('.hero-text svg');
    const paths = document.querySelectorAll('.hero-text path');
    
    // Prépare chaque path
    paths.forEach(path => {
        const length = path.getTotalLength();
        path.style.strokeDasharray = length;
        path.style.strokeDashoffset = length;
        path.style.fill = 'none';
        path.style.stroke = '#957B4D'; // Couleur or pour le stroke
    });

    // Crée une timeline GSAP
    const tl = gsap.timeline({
        onComplete: () => {
            // Quand l'animation est terminée, ajoute la classe
            svg.classList.add('animation-complete');
        }
    });

    // Anime d'abord tous les strokes en même temps
    tl.to(paths, {
        strokeDashoffset: 0,
        duration: 4, // Durée totale de 4 secondes
        ease: "power2.inOut",
        stagger: 0.05 // Petit décalage entre chaque path pour un effet plus naturel
    })
    // Puis remplit tous les paths en blanc en même temps, en commençant à la moitié de l'animation du stroke
    .to(paths, {
        fill: '#fff',
        duration: 1,
        ease: "power2.inOut"
    }, "-=4") // Commence à la moitié de l'animation du stroke (4/2 = 2 secondes)
    // Supprime le stroke une fois le fill appliqué
    .to(paths, {
        stroke: 'none',
        duration: 0.5,
        ease: "power2.inOut"
    }, "-=2.5"); // Commence juste après le début du fill

    // Démarre l'animation
    tl.play();
}); 