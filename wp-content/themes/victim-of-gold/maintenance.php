<?php
require_once('../../../wp-load.php');
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php bloginfo('name'); ?> - Maintenance</title>
    <!-- GSAP CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-color: #000;
            font-family: serif;
        }
        .maintenance-container {
            text-align: center;
            padding: 20px;
            width: 90%;
            max-width: 800px;
            margin: 0 auto;
        }
        .maintenance-svg {
            width: 100%;
            height: auto;
            max-width: 100%;
            max-height: 80vh;
        }
        .coming-soon {
            color: #957B4D;
            font-size: clamp(36px, 8vw, 72px);
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: clamp(3px, 1.5vw, 6px);
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
            margin-bottom: clamp(30px, 6vw, 60px);
            font-family: serif;
        }
        @media (max-width: 768px) {
            .maintenance-container {
                width: 95%;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="maintenance-container">
        <h1 class="coming-soon">COMING SOON</h1>
        <object id="svgObject" class="maintenance-svg" type="image/svg+xml" data="<?php echo get_template_directory_uri(); ?>/assets/images/maintenance.svg"></object>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const svgObject = document.getElementById('svgObject');
            
            svgObject.addEventListener('load', function() {
                const svgDoc = svgObject.contentDocument;
                
                // Appliquer la couleur dorée à tous les éléments du SVG
                const allElements = svgDoc.querySelectorAll('path, text, g');
                allElements.forEach(element => {
                    if (element.getAttribute('fill') !== 'none') {
                        element.setAttribute('fill', '#957B4D');
                    }
                });

                // Animation de rotation BEAUCOUP plus lente pour tout le SVG
                gsap.to(svgDoc.documentElement, {
                    rotation: 360,
                    duration: 300, // 5 minutes pour un tour complet
                    repeat: -1,
                    ease: "none",
                    transformOrigin: "center center"
                });

                // Animation d'opacité BEAUCOUP plus lente pour les lettres
                const letters = svgDoc.querySelectorAll('text');
                letters.forEach(letter => {
                    gsap.to(letter, {
                        opacity: 0.5,
                        duration: 5,
                        repeat: -1,
                        yoyo: true,
                        ease: "sine.inOut",
                        delay: Math.random() * 8
                    });
                });
            });
        });
    </script>
</body>
</html> 