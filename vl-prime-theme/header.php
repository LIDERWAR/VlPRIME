<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/assets/favicon.ico" type="image/x-icon">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <!-- Header -->
    <header class="header">
        <div class="container header__container">
            <div class="header__left">
                <?php
                $custom_logo_id = get_theme_mod('custom_logo');
                $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
                if (has_custom_logo()) {
                    echo '<a href="' . home_url() . '" class="logo"><img src="' . esc_url($logo[0]) . '" alt="' . get_bloginfo('name') . '" class="logo__img"></a>';
                } else {
                    echo '<a href="' . home_url() . '" class="logo"><img src="' . get_template_directory_uri() . '/assets/icon/logo.svg" alt="VL Prime Logo" class="logo__img"></a>';
                }
                ?>

                <div class="header__socials">
                    <?php
                    $whatsapp = get_field('whatsapp_link', 'option');
                    $telegram = get_field('telegram_link', 'option');
                    $phone = get_field('phone_number', 'option');

                    if ($whatsapp): ?>
                        <a href="<?php echo esc_url($whatsapp); ?>" class="social-link" aria-label="WhatsApp"
                            style="--icon-url: url('<?php echo get_template_directory_uri(); ?>/assets/icon/social/whatsapp.svg')"></a>
                    <?php endif;

                    if ($telegram): ?>
                        <a href="<?php echo esc_url($telegram); ?>" class="social-link" aria-label="Telegram"
                            style="--icon-url: url('<?php echo get_template_directory_uri(); ?>/assets/icon/social/telegram.svg')"></a>
                    <?php endif;

                    if ($phone):
                        $phone_clean = preg_replace('/[^0-9+]/', '', $phone);
                        ?>
                        <a href="tel:<?php echo esc_attr($phone_clean); ?>" class="social-link" aria-label="Phone"
                            style="--icon-url: url('<?php echo get_template_directory_uri(); ?>/assets/icon/social/phone.svg')"></a>
                    <?php endif; ?>
                </div>
            </div>

            <nav class="nav">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'container' => false,
                    'menu_class' => 'nav__list',
                    'fallback_cb' => false, // We'll rely on WP menu
                ));
                ?>
            </nav>

            <button class="burger-menu" aria-label="Открыть меню">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </header>