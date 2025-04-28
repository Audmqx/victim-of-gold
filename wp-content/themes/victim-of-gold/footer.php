<!-- HORAIRES SECTION -->
<section class="horaires-section">
    <div class="horaires-container">
        <div class="horaires-list">
            <div class="horaire-item">
                <h3>HORAIRES BOUTIQUE</h3>
                <p>Du Lundi au Dimanche
10.00 - 19.00</p>
            </div>
            <div class="horaire-item">
                <h3>HORAIRES CAFÉ</h3>
                <p>Du Lundi au Dimanche
09.00 - 23.00</p>
            </div>
        </div>
    </div>
</section>

<!-- ADRESSE SECTION -->
<section class="map-section">
    <div class="adresse-container">
        <p class="adresse">112 Allée des Oliviers, 06400 Cannes</p>
    </div>
    
    <div class="map-container">
        <div id="google-map"></div>
        <div class="map-overlay"></div>
    </div>
</section>

<!-- NEWSLETTER SECTION -->
<section class="newsletter-section">
    <div class="newsletter-container">
        <h2>NEWSLETTER</h2>
        <p>Recevez notre newsletter et découvrez nos histoires, nos collections et nos surprises.</p>
        <?php echo do_shortcode('[mailpoet_form id="1"]'); ?>
    </div>
</section>

<!-- FOOTER -->
<footer class="footer">
    <div class="footer-main">
        <div class="footer-links">
            <a href="/mentions-legales">Mentions légales</a>
            <a href="/politique-de-confidentialite">Politique de confidentialité</a>
            <a href="/contact">Contact</a>
        </div>
        <div class="footer-contact">
            <p>+33 (0)7 65 98 46 65</p>
            <p>contact@victimofgold.com</p>
            <p>112 Allée des Oliviers, 06400 Cannes</p>
        </div>
        <div class="footer-social">
            <h3>Suivez-nous sur les réseaux</h3>
        </div>
    </div>
    <div class="footer-copyright">
        <p>&copy; <?php echo date('Y'); ?> VICTIM OF GOLD</p>
    </div>
</footer>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Google Maps initialization
    function initMap() {
        var location = {lat: 43.552847, lng: 7.017369}; // Coordonnées de Cannes
        var map = new google.maps.Map(document.getElementById('google-map'), {
            zoom: 15,
            center: location,
            styles: [
                {
                    "elementType": "geometry",
                    "stylers": [{"color": "#212121"}]
                },
                {
                    "elementType": "labels.text.stroke",
                    "stylers": [{"color": "#212121"}]
                },
                {
                    "elementType": "labels.text.fill",
                    "stylers": [{"color": "#957B4D"}]
                }
            ]
        });

        var marker = new google.maps.Marker({
            position: location,
            map: map,
            icon: {
                url: '<?php echo get_template_directory_uri(); ?>/assets/images/map-marker.png',
                scaledSize: new google.maps.Size(40, 40)
            }
        });
    }

    // Load Google Maps
    if (typeof google === 'undefined') {
        var script = document.createElement('script');
        script.src = 'https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap';
        script.async = true;
        script.defer = true;
        document.head.appendChild(script);
    } else {
        initMap();
    }
});
</script>

<?php wp_footer(); ?>
</body>
</html> 