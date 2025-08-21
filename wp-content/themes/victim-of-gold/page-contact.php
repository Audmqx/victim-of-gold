<?php
get_header();
?>
<main id="main" class="site-main contact-main">
    <section class="contact-section">
        <div class="contact-container">
            <div class="contact-left">
                <div class="contact-image-bg">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/contact.png" alt="Contact" />
                </div>
                <div class="contact-infos">
                    <div class="contact-info">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icone-email.svg" alt="Email" />
                        <span>cannes@victimofgold.com</span>
                    </div>
                    <div class="contact-info">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icone instagram.svg" alt="Téléphone" />
                        <span>+33 (0)4 97 06 80 01</span>
                    </div>
                    <div class="contact-info">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icone-tel.svg" alt="Instagram" />
                        <a href="https://instagram.com/vog.cannes" target="_blank">@vog.cannes</a>
                    </div>
                </div>
            </div>
            <div class="contact-right">
                <h2 class="contact-title">PRENONS CONTACT</h2>
                <div class="contact-form-wrapper">
                    <?php echo do_shortcode('[mailpoet_form id="3"]'); ?>
                </div>
            </div>
        </div>
    </section>
</main>
<?php get_footer(); ?>