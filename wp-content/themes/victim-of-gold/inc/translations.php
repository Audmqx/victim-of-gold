<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme string translations.
 * French strings are used as fallbacks directly in templates.
 * Add 'ru' and 'zh' entries when those translations are ready.
 */
function vog_get_translations(): array
{
    return [
        'en' => [
            // Front page
            'home.about'          => 'Victim of Gold is a concept store combining pure 24-carat gold and a unique savoir-faire: Workshop, Boutique &amp; Café to discover and live a golden experience.',
            'home.read_more'      => 'Read',
            'home.video_fallback' => 'Your browser does not support video playback.',

            // Café page
            'cafe.p1' => 'Step into a sanctuary of sensation.<br class="desktop-break"> Housed in a lovingly reimagined heritage building, our café offers a culinary and interactive journey that shimmers with touches of gold.',
            'cafe.p2' => 'Whether you&#8217;re planning an intimate lunch, a relaxed coffee with friends, a business gathering, or family time,<br class="desktop-break"> every visit promises a little everyday magic.',

            // Contact page
            'contact.title' => 'GET IN TOUCH',

            // Footer
            'footer.hours_boutique'   => 'BOUTIQUE HOURS',
            'footer.hours_cafe'       => 'CAFÉ HOURS',
            'footer.hours_schedule'   => 'Tuesday to Saturday, 10am – 7pm',
            'footer.newsletter_title' => 'NEWSLETTER',
            'footer.newsletter_text'  => 'Receive our newsletter and discover our stories, collections and surprises.',
            'footer.legal'            => 'Legal Notice',
            'footer.privacy'          => 'Privacy Policy',
            'footer.follow'           => 'Follow us',

            // WooCommerce
            'wc.add_to_cart'    => 'Add to cart',
            'wc.view_cart'      => 'View cart',
            'wc.checkout'       => 'Checkout',
            'wc.added_single'   => '%s has been added to your cart.',
            'wc.added_multiple' => 'The products have been added to your cart.',

            // Image alt texts
            'cafe.alt.terrasse'   => 'Café terrace',
            'cafe.alt.vanille'    => 'Vanilla dessert',
            'cafe.alt.champagne'  => 'Champagne',
            'cafe.alt.gold'       => 'Gold Coffee',
            'cafe.alt.glace'      => 'Golden ice cream',
            'cafe.alt.choco'      => 'Chocolate ice cream',
            'cafe.alt.hero'       => 'Victim of Gold Café',
        ],

        'ru' => [
            // WooCommerce
            'wc.add_to_cart'    => 'В корзину',
            'wc.view_cart'      => 'Просмотр корзины',
            'wc.checkout'       => 'Оформить заказ',
            'wc.added_single'   => '%s добавлен в корзину.',
            'wc.added_multiple' => 'Товары добавлены в корзину.',

            // Front page
            'home.about'          => 'Victim of Gold — концепт-стор, объединяющий чистое золото 24 карат и уникальное в мире мастерство: Ателье, Бутик и Кафе, где можно открыть для себя и прочувствовать настоящий золотой опыт.',
            'home.read_more'      => 'Читать',
            'home.video_fallback' => 'Ваш браузер не поддерживает воспроизведение видео.',

            // Café page
            'cafe.p1' => 'Место вне времени, где начинается волшебное путешествие.<br class="desktop-break"> Дом с глубокими традициями, переосмысленный для чувственного, гастрономического и интерактивного путешествия.',
            'cafe.p2' => 'Будь то романтический обед, дружеская беседа за чашкой кофе, деловая встреча или семейный ужин —<br class="desktop-break"> здесь вас ждут по-настоящему уникальные эмоции, где страсть к золоту превращается в магию.',

            // Contact page
            'contact.title' => 'СВЯЗАТЬСЯ С НАМИ',

            // Footer
            'footer.hours_boutique'   => 'ЧАСЫ РАБОТЫ БУТИКА',
            'footer.hours_cafe'       => 'ЧАСЫ РАБОТЫ КАФЕ',
            'footer.hours_schedule'   => 'Со вторника по субботу, с 10:00 до 19:00',
            'footer.newsletter_title' => 'РАССЫЛКА',
            'footer.newsletter_text'  => 'Подпишитесь на нашу рассылку и узнавайте наши истории, коллекции и сюрпризы.',
            'footer.legal'            => 'Правовая информация',
            'footer.privacy'          => 'Политика конфиденциальности',
            'footer.follow'           => 'Следите за нами',

            // Image alt texts
            'cafe.alt.terrasse'   => 'Терраса кафе',
            'cafe.alt.vanille'    => 'Десерт с ванилью',
            'cafe.alt.champagne'  => 'Шампанское',
            'cafe.alt.gold'       => 'Золотой кофе',
            'cafe.alt.glace'      => 'Золотое мороженое',
            'cafe.alt.choco'      => 'Шоколадное мороженое',
            'cafe.alt.hero'       => 'Кафе Victim of Gold',
        ],

        'zh' => [
            // WooCommerce
            'wc.add_to_cart'    => '加入购物车',
            'wc.view_cart'      => '查看购物车',
            'wc.checkout'       => '结账',
            'wc.added_single'   => '%s 已加入购物车。',
            'wc.added_multiple' => '商品已加入购物车。',

            // Front page
            'home.about'          => 'Victim of Gold 是一家融合纯24K金与世界独一无二工艺的概念店：工坊、精品店与咖啡馆，带您探索并体验一段黄金之旅。',
            'home.read_more'      => '阅读',
            'home.video_fallback' => '您的浏览器不支持视频播放。',

            // Café page
            'cafe.p1' => '一处跨越时光的感官圣地。<br class="desktop-break"> 在一座焕新演绎的传统建筑中，踏上融合美食、互动与艺术的奇幻旅程。',
            'cafe.p2' => '无论是浪漫午餐、好友小聚、商务会晤或与家人的温馨时光，<br class="desktop-break"> 这里都能带来一段闪耀金光的独特体验。',

            // Contact page
            'contact.title' => '联系我们',

            // Footer
            'footer.hours_boutique'   => '精品店营业时间',
            'footer.hours_cafe'       => '咖啡馆营业时间',
            'footer.hours_schedule'   => '周二至周六，10:00 – 19:00',
            'footer.newsletter_title' => '电子通讯',
            'footer.newsletter_text'  => '订阅我们的电子报，探索我们的故事、系列与惊喜。',
            'footer.legal'            => '法律声明',
            'footer.privacy'          => '隐私政策',
            'footer.follow'           => '关注我们',

            // Image alt texts
            'cafe.alt.terrasse'   => '咖啡馆露台',
            'cafe.alt.vanille'    => '香草甜点',
            'cafe.alt.champagne'  => '香槟',
            'cafe.alt.gold'       => '黄金咖啡',
            'cafe.alt.glace'      => '黄金冰淇淋',
            'cafe.alt.choco'      => '巧克力冰淇淋',
            'cafe.alt.hero'       => 'Victim of Gold 咖啡馆',
        ],
    ];
}

/**
 * Returns the translated string for $key.
 * Uses vog_current_lang() which calls pll_current_language() when Polylang is active.
 * Falls back to $fallback (the French string) when no translation exists.
 * Safe to echo — content is hardcoded here, not user input.
 */
function vog_t(string $key, string $fallback = ''): string
{
    $lang = vog_current_lang();
    if ($lang === 'fr') {
        return $fallback;
    }
    $translations = vog_get_translations();
    return $translations[$lang][$key] ?? $fallback;
}
