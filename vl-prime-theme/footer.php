<!-- Footer -->
<footer id="main-footer" class="footer">
    <div class="container">
        <div class="footer__inner">
            <div class="footer__col footer__col--info">
                <a href="<?php echo home_url(); ?>" class="footer__logo-link">
                    <?php
                    if (has_custom_logo()) {
                        $custom_logo_id = get_theme_mod('custom_logo');
                        $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
                        echo '<img src="' . esc_url($logo[0]) . '" alt="' . get_bloginfo('name') . '" class="footer__logo-img">';
                    } else {
                        echo '<img src="' . get_template_directory_uri() . '/assets/icon/logo.svg" alt="VL Prime" class="footer__logo-img">';
                    }
                    ?>
                </a>
                <p class="footer__desc">
                    Специализированный сервис Volvo в Москве.
                    Профессиональный ремонт и обслуживание с гарантией качества и соблюдением стандартов
                    производителя.
                </p>
            </div>

            <div class="footer__col">
                <h4 class="footer__title">Навигация</h4>
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'footer',
                    'container' => false,
                    'menu_class' => 'footer__nav',
                    'fallback_cb' => false,
                ));
                ?>
            </div>

            <div class="footer__col">
                <h4 class="footer__title">Контакты</h4>
                <ul class="footer__contacts">
                    <?php
                    $phone = get_field('phone_number', 'option');
                    $address = get_field('address_text', 'option');

                    if ($phone):
                        $phone_clean = preg_replace('/[^0-9+]/', '', $phone);
                        ?>
                        <li>
                            <a href="tel:<?php echo esc_attr($phone_clean); ?>"
                                class="footer__phone"><?php echo esc_html($phone); ?></a>
                        </li>
                    <?php endif;

                    if ($address): ?>
                        <li class="footer__address"><?php echo esc_html($address); ?></li>
                    <?php endif; ?>

                    <li class="footer__worktime">Пн-Вс: 09:00 - 21:00</li>
                </ul>
            </div>
        </div>

        <div class="footer__bottom">
            <div class="footer__copyright">
                &copy; <?php echo date('Y'); ?> VL Prime. Все права защищены.
            </div>
            <div class="footer__legal">
                <a href="#">Политика конфиденциальности</a>
                <a href="#">Согласие на обработку</a>
            </div>
        </div>
    </div>
</footer>

<!-- Floating Scroll Buttons -->
<div class="scroll-nav">
    <button id="scrollTop" class="scroll-nav__btn" aria-label="Наверх">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round">
            <polyline points="18 15 12 9 6 15"></polyline>
        </svg>
    </button>
    <button id="scrollBottom" class="scroll-nav__btn" aria-label="Вниз">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round">
            <polyline points="6 9 12 15 18 9"></polyline>
        </svg>
    </button>
</div>

<?php wp_footer(); ?>
</body>

</html>