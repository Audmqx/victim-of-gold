<?php
/**
 * Template personnalisé Login Mon Compte pour Victim of Gold
 * Basé sur WooCommerce 7.x
 */
if (!defined('ABSPATH')) {
    exit;
}
?>
<form class="woocommerce-form woocommerce-form-login login" method="post">
    <?php do_action('woocommerce_login_form_start'); ?>
    <p class="form-row form-row-wide">
        <label for="username"><?php esc_html_e('Username or email address', 'woocommerce'); ?> <span class="required">*</span></label>
        <input type="text" class="input-text" name="username" id="username" autocomplete="username" value="<?php echo (!empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>" />
    </p>
    <p class="form-row form-row-wide password-row" style="position:relative;">
        <label for="password"><?php esc_html_e('Password', 'woocommerce'); ?> <span class="required">*</span></label>
        <input class="input-text" type="password" name="password" id="password" autocomplete="current-password" />
        <span class="toggle-password" style="position:absolute;right:16px;top:52px;cursor:pointer;display:flex;align-items:center;">
            <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24"><path stroke="#1D1D1B" stroke-width="2" d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12Z"/><circle cx="12" cy="12" r="3" stroke="#1D1D1B" stroke-width="2"/></svg>
        </span>
    </p>
    <div class="form-row form-row-remember" style="display:flex;align-items:center;gap:8px;margin-bottom:18px;">
        <label for="rememberme" style="margin:0;display:flex;align-items:center;gap:8px;">
            <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" />
            <span><?php esc_html_e('Remember me', 'woocommerce'); ?></span>
        </label>
    </div>
    <?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
    <div class="login-actions">
        <button type="submit" class="woocommerce-button button woocommerce-form-login__submit" name="login" value="<?php esc_attr_e('Log in', 'woocommerce'); ?>"><?php esc_html_e('Log in', 'woocommerce'); ?></button>
        <p class="woocommerce-LostPassword lost_password">
            <a href="<?php echo esc_url(wp_lostpassword_url()); ?>"><?php esc_html_e('Lost your password?', 'woocommerce'); ?></a>
        </p>
    </div>
    <?php do_action('woocommerce_login_form'); ?>
    <?php do_action('woocommerce_login_form_end'); ?>
</form>
<script>
// Afficher/masquer le mot de passe
(function(){
    const pwdInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eye-icon');
    if(pwdInput && eyeIcon) {
        eyeIcon.addEventListener('click', function() {
            if (pwdInput.type === 'password') {
                pwdInput.type = 'text';
            } else {
                pwdInput.type = 'password';
            }
        });
    }
})();
</script> 