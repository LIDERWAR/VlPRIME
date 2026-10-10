<?php get_header(); ?>

<!-- Hero Section -->
<section id="hero" class="hero">
    <div class="hero__overlay"></div>
    <?php
    $hero_bg = get_field('hero_bg_image');
    if ($hero_bg): ?>
        <style>
            .hero {
                background-image: url('<?php echo esc_url($hero_bg); ?>');
            }
        </style>
    <?php else: ?>
        <style>
            .hero {
                background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/background_hero.png');
            }
        </style>
    <?php endif; ?>

    <div class="container">
        <div class="hero__content">
            <span class="hero__overhead"><?php the_field('hero_overhead'); ?></span>
            <h1 class="hero__title"><?php echo nl2br(get_field('hero_title')); ?></h1>
            <p class="hero__subtitle"><?php echo nl2br(get_field('hero_subtitle')); ?></p>
            <a href="<?php echo home_url('/service/'); ?>#booking" class="btn btn--primary">Записаться</a>
        </div>
    </div>
</section>

<!-- About Section -->
<section id="about" class="about section-padding">
    <div class="container">
        <div class="about__inner">
            <div class="about__content">
                <span class="section-overhead">О КОМПАНИИ</span>
                <h2 class="section-title about__title"><?php the_field('about_title'); ?></h2>
                <div class="about__text">
                    <?php the_field('about_text_main'); ?>
                </div>
                <a href="#main-services" class="btn btn--primary">Наши услуги</a>
            </div>
            <div class="about__visual">
                <?php
                $about_img = get_field('about_image');
                if ($about_img): ?>
                    <img src="<?php echo esc_url($about_img); ?>" alt="О компании" class="about__img">
                <?php else: ?>
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/about_main.jpg" alt="О компании"
                        class="about__img">
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Services Section (Hardcoded for now per plan, can be dyn later) -->
<section id="services" class="services section-padding">
    <div class="container">
        <div class="section-header text-center">
            <span class="section-overhead">ДЛЯ КОГО МЫ РАБОТАЕМ</span>
            <h2 class="section-title">Мы обслуживаем</h2>
        </div>

        <div class="services__grid">
            <!-- Service Card 1 -->
            <article class="service-card service-card--private">
                <div class="service-card__icon-box">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </div>
                <h3 class="service-card__title">Частные клиенты</h3>
                <p class="service-card__text">
                    Персональный подход к каждому владельцу Volvo. Прозрачная история обслуживания и комфортная зона
                    ожидания.
                </p>
            </article>

            <!-- Service Card 2 -->
            <article class="service-card service-card--corporate">
                <div class="service-card__icon-box">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                        stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                    </svg>
                </div>
                <h3 class="service-card__title">Корпоративные парки</h3>
                <p class="service-card__text">
                    Специальные условия для юридических лиц. Полный пакет документов, работа с НДС и приоритетная
                    запись.
                </p>
            </article>

            <!-- Service Card 3 -->
            <article class="service-card service-card--postwarranty">
                <div class="service-card__icon-box">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path
                            d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3">
                        </path>
                    </svg>
                </div>
                <h3 class="service-card__title">Постгарантия</h3>
                <p class="service-card__text">
                    Профессиональное обслуживание автомобилей с пробегом. Оригинальные запчасти и качественные
                    аналоги.
                </p>
            </article>
        </div>
    </div>
</section>

<!-- Main Services Section -->
<section id="main-services" class="main-services section-padding">
    <div class="container">
        <div class="section-header text-center">
            <span class="section-overhead">КОМПЛЕКСНЫЙ ПОДХОД</span>
            <h2 class="section-title">Наши основные услуги</h2>
        </div>

        <div class="main-services__grid">
            <!-- Service Items (Using static logic for now, keeping structure) -->
            <!-- Card 1 -->
            <a href="<?php echo home_url('/service/'); ?>#service-maintenance" class="ms-card ms-card--service-1">
                <div class="ms-card__icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.5">
                        <path
                            d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z">
                        </path>
                    </svg>
                </div>
                <h3 class="ms-card__title">Техническое обслуживание</h3>
                <ul class="ms-card__list">
                    <li>Замена масла и фильтров</li>
                    <li>Проверка тех. жидкостей</li>
                    <li>Замена тормозных колодок</li>
                </ul>
            </a>

            <!-- ... Other cards would go here, kept static for brevity in this step ... -->
            <!-- Card 2 -->
            <a href="<?php echo home_url('/service/'); ?>#service-diagnostics" class="ms-card ms-card--service-2">
                <div class="ms-card__icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.5">
                        <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                    </svg>
                </div>
                <h3 class="ms-card__title">Компьютерная диагностика</h3>
                <ul class="ms-card__list">
                    <li>Чтение кодов ошибок</li>
                    <li>Адаптация блоков</li>
                    <li>Обновление ПО</li>
                </ul>
            </a>
            <!-- We will add the rest in full implementation or loop -->

        </div>
    </div>
</section>

<!-- Promotions Section -->
<section id="promotions" class="promotions section-padding">
    <div class="container">
        <div class="section-header text-center">
            <span class="section-overhead">СПЕЦИАЛЬНЫЕ ПРЕДЛОЖЕНИЯ</span>
            <h2 class="section-title">Выгодное обслуживание</h2>
        </div>
        <div class="promotions__grid">
            <!-- Promo 1 -->
            <div class="promo-card promo-card--primary">
                <div class="promo-card__content">
                    <span class="promo-card__label">НОВЫМ КЛИЕНТАМ</span>
                    <h3 class="promo-card__title">Бесплатная диагностика<br>ходовой части</h3>
                    <p class="promo-card__text">При первом посещении нашего сервиса — полная проверка подвески в
                        подарок.</p>
                    <a href="<?php echo home_url('/service/'); ?>?promo=free_diagnostics#service-mechanical"
                        class="btn btn--outline">Записаться</a>
                </div>
                <div class="promo-card__bg"></div>
            </div>
            <!-- Promo 2 -->
            <div class="promo-card promo-card--secondary">
                <div class="promo-card__content">
                    <span class="promo-card__label">СЕЗОННОЕ ПРЕДЛОЖЕНИЕ</span>
                    <h3 class="promo-card__title">Скидка 15% на<br>масляный сервис</h3>
                    <p class="promo-card__text">При покупке масла и фильтров в нашем магазине — замена со скидкой.</p>
                    <a href="<?php echo home_url('/service/'); ?>?promo=oil_discount#service-maintenance"
                        class="btn btn--outline">Получить скидку</a>
                </div>
                <div class="promo-card__bg"></div>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>