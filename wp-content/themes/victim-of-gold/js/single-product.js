jQuery(document).ready(function($) {
    // Accordion functionality
    $('.accordion-item h3').on('click', function() {
        const $item = $(this).parent();
        const $content = $item.find('.accordion-content');
        
        if ($item.hasClass('active')) {
            $item.removeClass('active');
            $content.slideUp();
        } else {
            $('.accordion-item').removeClass('active');
            $('.accordion-content').slideUp();
            $item.addClass('active');
            $content.slideDown();
        }
    });

    // Product gallery functionality
    const $gallery = $('.woocommerce-product-gallery');
    const $mainImageWrapper = $('.gallery-main-image');
    const $mainImage = $mainImageWrapper.find('img').first();
    const $thumbnails = $('.vog-thumbnail');
    
    // Fonction pour vérifier si on est sur mobile
    const isMobile = () => window.matchMedia('(max-width: 768px)').matches;
    
    // Désactiver le zoom sur mobile
    if (isMobile()) {
        $mainImageWrapper.trigger('zoom.destroy');
    }
    
    // Marquer la première miniature comme active
    $thumbnails.first().addClass('active');
    
    // Gérer le clic sur les miniatures
    $thumbnails.on('click', function(e) {
        e.preventDefault();
        const $this = $(this);
        const fullImageUrl = $this.data('full-image');
        
        // Créer une nouvelle image pour le préchargement
        const newImage = new Image();
        newImage.src = fullImageUrl;
        
        newImage.onload = function() {
            // Mettre à jour l'image principale
            $mainImage.attr('src', fullImageUrl);
            $mainImage.attr('srcset', ''); // Effacer le srcset pour éviter les conflits
            $mainImage.attr('data-large_image', fullImageUrl);
            $mainImage.attr('data-src', fullImageUrl);
            $mainImageWrapper.attr('data-thumb', fullImageUrl);
            
            // Mettre à jour la classe active
            $thumbnails.removeClass('active');
            $this.addClass('active');
            
            // Réinitialiser le zoom seulement sur desktop
            if (!isMobile() && typeof $.fn.zoom === 'function') {
                $mainImageWrapper.trigger('zoom.destroy'); // Détruire le zoom existant
                $mainImageWrapper.zoom({ // Réinitialiser le zoom
                    url: fullImageUrl,
                    touch: false
                });
            }
        };
        
        return false;
    });
    
    // Gérer le redimensionnement de la fenêtre
    $(window).on('resize', function() {
        if (isMobile()) {
            $mainImageWrapper.trigger('zoom.destroy');
        } else if (typeof $.fn.zoom === 'function') {
            $mainImageWrapper.zoom({
                url: $mainImage.attr('data-large_image'),
                touch: false
            });
        }
    });
}); 