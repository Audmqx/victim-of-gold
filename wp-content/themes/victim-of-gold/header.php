<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="top-bar">
    <div class="top-bar-content">
        <div class="menu-container">
            <div class="logo-container">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="custom-logo-link">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Logo.svg" 
                         alt="<?php echo esc_attr(get_bloginfo('name')); ?>" 
                         class="custom-logo">
                </a>
            </div>
            
            <nav class="menu" role="navigation" aria-label="Menu principal">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_class' => 'menu',
                    'container' => false,
                    'items_wrap' => '<ul class="menu">%3$s</ul>',
                    'walker' => new VOG_Menu_Walker()
                ));
                ?>

                <div class="language-selector">
                    <a href="<?php echo esc_url(home_url('/?lang=fr')); ?>" class="<?php echo (get_locale() === 'fr_FR') ? 'active' : ''; ?>">FR</a>
                    <span>.</span>
                    <a href="<?php echo esc_url(home_url('/?lang=en')); ?>" class="<?php echo (get_locale() === 'en_US') ? 'active' : ''; ?>">EN</a>
                </div>
            </nav>

            <button class="hamburger" aria-label="Menu" aria-expanded="false" aria-controls="menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </div>
</header>

<?php
// Custom Walker pour le menu
class VOG_Menu_Walker extends Walker_Nav_Menu {
    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        $output .= '<li>';
        $output .= sprintf(
            '<a href="%s" data-text="%s">%s</a>',
            esc_url($item->url),
            esc_attr($item->title),
            esc_html($item->title)
        );
    }
}
?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const hamburger = document.querySelector('.hamburger');
    const menu = document.querySelector('.menu');
    const body = document.body;
    let scrollPosition = 0;

    function toggleMenu() {
        const isOpen = hamburger.classList.toggle('active');
        menu.classList.toggle('active');
        hamburger.setAttribute('aria-expanded', isOpen);
        
        if (isOpen) {
            scrollPosition = window.pageYOffset;
            body.classList.add('menu-open');
            // Attendre que l'animation de slide soit terminée
            setTimeout(() => {
                menu.querySelector('a').focus();
            }, 400);
        } else {
            body.classList.remove('menu-open');
            window.scrollTo(0, scrollPosition);
        }
    }

    hamburger.addEventListener('click', function(e) {
        e.stopPropagation();
        toggleMenu();
    });

    // Gérer la navigation au clavier
    menu.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            toggleMenu();
        }
    });

    // Fermer le menu au clic sur un lien
    menu.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', function() {
            toggleMenu();
        });
    });

    // Empêcher la propagation des clics dans le menu
    menu.addEventListener('click', function(e) {
        e.stopPropagation();
    });

    // Fermer le menu si la fenêtre est redimensionnée au-dessus de 1024px
    window.addEventListener('resize', function() {
        if (window.innerWidth > 1024 && menu.classList.contains('active')) {
            toggleMenu();
        }
    });
});
</script> 