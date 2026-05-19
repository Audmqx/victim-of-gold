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
                        <span>04 97 06 94 09</span>
                    </div>
                    <div class="contact-info">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icone-tel.svg" alt="Instagram" />
                        <a href="https://instagram.com/vog.cannes" target="_blank">@vog.cannes</a>
                    </div>
                </div>
            </div>
            <div class="contact-right">
                <h2 class="contact-title"><?php echo vog_t('contact.title', 'PRENONS CONTACT'); ?></h2>
                <div class="contact-form-wrapper">
                    <?php
                    $form_html = do_shortcode('[mailpoet_form id="3"]');
                    $lang      = vog_current_lang();

                    if ($lang !== 'fr') {
                        $strings = [
                            'en' => [
                                // Champs (avec et sans astérisque)
                                'Nom/Prénom *'         => 'Name *',
                                'Nom/Prénom'           => 'Name',
                                'Adresse e-mail *'     => 'Email address *',
                                'Adresse e-mail'       => 'Email address',
                                'Objet *'              => 'Subject *',
                                'Objet'                => 'Subject',
                                'Message *'            => 'Message *',
                                // Bouton
                                'value="Envoyer"'      => 'value="Send"',
                                // Messages parsley
                                'Ce champ est nécessaire.'                => 'This field is required.',
                                'Cette valeur doit être un e-mail valide.' => 'Please enter a valid email address.',
                                'Veuillez spécifier un nom valide.'       => 'Please enter a valid name.',
                                'Les adresses dans les noms ne sont pas autorisées, veuillez ajouter votre nom à la place.' => 'Addresses in names are not allowed, please use your name instead.',
                                // Honeypot
                                'Veuillez laisser ce champ vide'          => 'Please leave this field empty',
                                // Message de succès
                                'Merci, à bientôt !'  => 'Thank you, see you soon!',
                            ],
                            'ru' => [
                                'Nom/Prénom *'         => 'Имя *',
                                'Nom/Prénom'           => 'Имя',
                                'Adresse e-mail *'     => 'Адрес эл. почты *',
                                'Adresse e-mail'       => 'Адрес эл. почты',
                                'Objet *'              => 'Тема *',
                                'Objet'                => 'Тема',
                                'Message *'            => 'Сообщение *',
                                'value="Envoyer"'      => 'value="Отправить"',
                                'Ce champ est nécessaire.'                => 'Это поле обязательно.',
                                'Cette valeur doit être un e-mail valide.' => 'Введите корректный адрес эл. почты.',
                                'Veuillez spécifier un nom valide.'       => 'Введите корректное имя.',
                                'Les adresses dans les noms ne sont pas autorisées, veuillez ajouter votre nom à la place.' => 'Адреса в именах не разрешены, введите ваше имя.',
                                'Veuillez laisser ce champ vide'          => 'Пожалуйста, оставьте это поле пустым',
                                'Merci, à bientôt !'  => 'Спасибо, до скорой встречи!',
                            ],
                            'zh' => [
                                'Nom/Prénom *'         => '姓名 *',
                                'Nom/Prénom'           => '姓名',
                                'Adresse e-mail *'     => '电子邮箱 *',
                                'Adresse e-mail'       => '电子邮箱',
                                'Objet *'              => '主题 *',
                                'Objet'                => '主题',
                                'Message *'            => '留言 *',
                                'value="Envoyer"'      => 'value="发送"',
                                'Ce champ est nécessaire.'                => '此字段为必填项。',
                                'Cette valeur doit être un e-mail valide.' => '请输入有效的电子邮件地址。',
                                'Veuillez spécifier un nom valide.'       => '请输入有效的姓名。',
                                'Les adresses dans les noms ne sont pas autorisées, veuillez ajouter votre nom à la place.' => '姓名中不允许包含地址，请直接输入您的姓名。',
                                'Veuillez laisser ce champ vide'          => '请将此字段留空',
                                'Merci, à bientôt !'  => '感谢您，再见！',
                            ],
                        ];

                        if (!empty($strings[$lang])) {
                            $form_html = str_replace(
                                array_keys($strings[$lang]),
                                array_values($strings[$lang]),
                                $form_html
                            );
                        }
                    }

                    echo $form_html;
                    ?>
                </div>
            </div>
        </div>
    </section>
</main>
<?php get_footer(); ?>