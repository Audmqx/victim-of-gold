<footer class="footer">
    <div class="footer-logo">
        <?php
        if (has_custom_logo()) {
            the_custom_logo();
        }
        ?>
    </div>

    <div class="footer-address">
        <p>Notre Boutique</p>
        <p>112 boulevard de la croisette</p>
        <p>06400 Cannes, France</p>
        <p>07 12 34 56 78</p>
    </div>

    <div class="footer-social">
        <p>Suivez nous sur les réseaux</p>
        <?php
        // Add social media icons/links here
        ?>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html> 