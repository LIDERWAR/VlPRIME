<?php
/*
Template Name: Шаблон ГЛАВНОЙ страницы
*/
get_header();
?>

<!-- Hero Section -->
<section id="hero" class="hero" style="background-image: url('<?php echo get_field('hero_background')['url'] ?>');">
    <div class="hero__overlay"></div>
    <div class="container">
        <div class="hero__content">
            <span class="hero__overhead"><?php the_field('hero_subtitle'); ?></span>
            <h1 class="hero__title"><?php the_field('hero_title'); ?></h1>
            <p class="hero__subtitle"><?php the_field('hero_descr'); ?></p>
            <a href="<?php echo get_field('hero_btn')['url'] ?>" class="btn btn--primary">
                <?php echo get_field('hero_btn')['title'] ?>
            </a>
        </div>
    </div>
</section>

<!-- About Section -->
<section id="about" class="about section-padding">
    <div class="container">
        <div class="about__inner">
            <div class="about__content">
                <span class="section-overhead"><?php the_field('about_subtitle'); ?></span>
                <h2 class="section-title about__title"><?php the_field('about_title'); ?></h2>
                <p class="about__text"><?php the_field('about_descr'); ?>
                </p>
                <p class="about__text">
                    <?php the_field('about_descr_more'); ?>
                </p>
                <a href="<?php echo get_field('about_btn')['url'] ?>" class="btn btn--primary">
                    <?php echo get_field('about_btn')['title'] ?>
                </a>
            </div>
            <div class="about__visual">
                <!-- Placeholder for About Image -->
                <img src="<?php echo get_field('about_img')['url'] ?>" alt="<?php echo get_field('about_img')['alt'] ?>"
                    class="about__img">
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section id="services" class="services section-padding">
    <div class="container">
        <div class="section-header text-center">
            <span class="section-overhead"><?php the_field('services_subtitle'); ?></span>
            <h2 class="section-title"><?php the_field('services_title'); ?></h2>
        </div>
        <div class="services__grid castom-grid">
            <!-- Service Card  -->
            <?php
            if (
                have_rows('services_repeater')
            ):
                while (
                    have_rows('services_repeater')
                ):
                    the_row(); ?>
                    <article class="service-card" style="background-image: url('<?php echo get_sub_field('image')['url'] ?>');">
                        <div class="service-card__icon-box">
                            <?php echo get_sub_field('icon'); ?>

                        </div>
                        <h3 class="service-card__title"> <?php the_sub_field('title'); ?></h3>
                        <p class="service-card__text">
                            <?php the_sub_field('descr'); ?>
                        </p>
                    </article>


                    <?php
                endwhile;
            
            endif;
            ?>

        </div>
    </div>
</section>

<!-- Main Services Section -->
<section id="main-services" class="main-services section-padding">
    <div class="container">
        <div class="section-header text-center">
            <span class="section-overhead">
                <?php the_field('main_services_subtitle'); ?>
            </span>
            <h2 class="section-title">
                <?php the_field('main_services_title'); ?>
            </h2>
        </div>

        <div class="main-services__grid">
            <!-- Card  -->

            <?php
            if (have_rows('main_services_repeater')):
                while (have_rows('main_services_repeater')):
                    the_row(); ?>

                    <a href="<?php echo get_sub_field('link')['url']; ?>" class="ms-card">
                        <div class="ms-card__icon">
                            <?php echo get_sub_field('icon'); ?>
                        </div>
                        <h3 class="ms-card__title"> <?php the_sub_field('title'); ?></h3>
                        <ul class="ms-card__list">
                            <?php
                            if (have_rows('main_services_list')):
                                while (have_rows('main_services_list')):
                                    the_row(); ?>
                                    <li><?php the_sub_field('title'); ?></li>

                                    <?php
                                endwhile;
                            
                            endif;
                            ?>
                        </ul>
                    </a>
                    <?php
                endwhile;
            
            endif;
            ?>

        </div>
    </div>
</section>

<!-- Promotions Section -->
<section id="promotions" class="promotions section-padding">
    <div class="container">
        <div class="section-header text-center">
            <span class="section-overhead"><?php the_field('promotions_subtitle'); ?></span>
            <h2 class="section-title"><?php the_field('promotions_title'); ?></h2>
        </div>

        <div class="promotions__grid">

            <?php
            if (have_rows('promotions_repeater')):
                while (have_rows('promotions_repeater')):
                    the_row(); ?>

                    <div class="promo-card promo-card--primary"
                        style="background-image: url('<?php echo get_sub_field('image')['url'] ?>');">
                        <div class="promo-card__content">
                            <span class="promo-card__label"><?php the_sub_field('icon'); ?></span>
                            <h3 class="promo-card__title"><?php the_sub_field('title'); ?></h3>
                            <p class="promo-card__text"><?php the_sub_field('descr'); ?></p>
                            <a href="<?php echo get_sub_field('btn')['url'] ?>" class="btn btn--outline">
                                <?php echo get_sub_field('btn')['title'] ?>
                            </a>
                        </div>
                        <div class="promo-card__bg"></div>
                    </div>

                    <?php
                endwhile;
            
            endif;
            ?>
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section id="why-us" class="why-us section-padding">
    <div class="container">
        <div class="section-header text-center">
            <span class="section-overhead"><?php the_field('why_subtitle'); ?></span>
            <h2 class="section-title"><?php the_field('why_title'); ?></h2>
            <p class="section-subtitle"><?php the_field('why_descr'); ?></p>
        </div>

        <div class="advantages-grid">
            <!-- Large Feature Card (Experience) -->
            <div class="adv-card adv-card--large">
                <div class="adv-card__icon-box">
                    <?php echo get_field('large_icon'); ?>
                </div>
                <div class="adv-card__content">
                    <h3 class="adv-card__title"><?php the_field('large_title'); ?></h3>
                    <p class="adv-card__text"><?php the_field('large_descr'); ?></p>
                </div>
            </div>

            <!-- Tall Feature Card (Convenience) -->
            <div class="adv-card adv-card--tall adv-card--convenience">
                <div class="adv-card__icon-box">
                    <?php echo get_field('convenience_icon'); ?>
                </div>
                <h3 class="adv-card__title">
                    <?php the_field('convenience_title'); ?>
                </h3>
                <p class="adv-card__text">
                    <?php the_field('convenience_descr'); ?>
                </p>
                <div class="adv-card__bg"
                    style="background-image: url('<?php echo get_field('convenience_background')['url'] ?>');"></div>
            </div>

            <!-- Standard Cards -->
            <div class="adv-card adv-card--warranty">
                <div class="adv-card__icon-small">
                    <?php echo get_field('warranty_icon'); ?>
                </div>
                <h4 class="adv-card__subtitle">
                    <?php the_field('warranty_title'); ?>
                </h4>
                <p class="adv-card__text">
                    <?php the_field('warranty_descr'); ?>
                </p>
                <div class="adv-card__bg"
                    style="background-image: url('<?php echo get_field('warranty_background')['url'] ?>');"></div>
            </div>

            <div class="adv-card adv-card--vida">
                <div class="adv-card__icon-small">
                    <?php echo get_field('vida_icon'); ?>
                </div>
                <h4 class="adv-card__subtitle">
                    <?php the_field('vida_title'); ?>
                </h4>
                <p class="adv-card__text">
                    <?php the_field('vida_descr'); ?>
                </p>
                <div class="adv-card__bg"
                    style="background-image: url('<?php echo get_field('vida_background')['url'] ?>');"></div>
            </div>

            <!-- Full Width Card (Original Parts) -->
            <div class="adv-card adv-card--full">
                <div class="adv-card__icon-small">
                    <?php echo get_field('full_icon'); ?>

                </div>
                <h4 class="adv-card__subtitle"><?php echo get_field('full_title'); ?></h4>
                <p class="adv-card__text"><?php echo get_field('full_descr'); ?></p>
            </div>
        </div>
    </div>
    </div>
</section>

<!-- Facts Section -->
<!-- Process Section -->
<section id="process" class="process section-padding">
    <div class="container">
        <div class="section-header text-center">
            <span class="section-overhead"><?php the_field('process_subtitle'); ?></span>
            <h2 class="section-title"><?php the_field('process_title'); ?></h2>
        </div>
        <div class="process__steps">
            <?php
            $i = 1;
            if (have_rows('process_repeater')):
                while (have_rows('process_repeater')):
                    the_row(); ?>
                    <div class="process-step">
                        <span class="process-step__number"><?php echo $i; ?></span>
                        <h3 class="process-step__title"><?php the_sub_field('title'); ?></h3>
                        <p class="process-step__text"><?php the_sub_field('descr'); ?></p>
                    </div>
                    <?php
                    $i++;
                endwhile;
            
            endif;
            ?>
        </div>
    </div>
    <div class="process__cta">
        <a href="<?php echo get_field('process_btn')['url']; ?>" class="btn btn--primary">
            <?php echo get_field('process_btn')['title']; ?>
        </a>
    </div>
    </div>
</section>

<!-- Cases Section -->
<section id="cases" class="cases section-padding">
    <div class="container">
        <div class="section-header text-center">
            <span class="section-overhead"><?php the_field('cases_subtitle'); ?></span>
            <h2 class="section-title"><?php the_field('cases_title'); ?></h2>
        </div>
        <div class="cases__grid">
            <!-- Case -->
            <!-- ДОСТАЕМ ПОСТЫ ИЗ БАЗЫ ДАННЫХ -->
            <?php
            // задаем нужные нам критерии выборки данных из БД
            $args = array(
                'posts_per_page' => 3,
                'category_name' => 'gallery',
            );

            $query = new WP_Query($args);

            // Цикл
            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post(); ?>

                    <article class="blog-card" data-category="tips">
                        <div class="blog-card__image-box">
                            <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php echo get_the_title(); ?>"
                                class="blog-card__img">
                            <div class="blog-card__overlay"></div>
                            <span class="blog-card__date"><?php echo get_the_date(); ?></span>
                        </div>
                        <div class="blog-card__content">
                            <span class="blog-card__tag">
                                <?php echo get_the_term_list(get_the_ID(), 'category', '', ', ', ''); ?>
                            </span>
                            <h3 class="blog-card__title">
                                <?php echo get_the_title(); ?>
                            </h3>
                            <p class="blog-card__text">
                                <?php echo get_the_excerpt(); ?>
                            </p>
                            <a href="<?php echo get_the_permalink(); ?>" class="blog-card__link">Смотреть &rarr;</a>
                        </div>
                    </article>
                    <?php
                }
            } else {
                // Постов не найдено
            }

            // Возвращаем оригинальные данные поста. Сбрасываем $post.
            wp_reset_postdata(); ?>
        </div>

        <div class="cases__footer text-center" style="margin-top: 40px;">
            <a href="<?php echo get_field('cases_btn')['url']; ?>" class="btn btn--outline">
                <?php echo get_field('cases_btn')['title']; ?>
            </a>
        </div>
    </div>
</section>

<!-- Prices Section -->
<section id="prices" class="prices section-padding">
    <div class="container">
        <div class="section-header text-center">
            <span class="section-overhead"><?php the_field('prices_subtitle'); ?></span>
            <h2 class="section-title"><?php the_field('prices_title'); ?></h2>
            <p class="section-subtitle"><?php the_field('prices_descr'); ?></p>
        </div>

        <div class="prices__content">
            <div class="prices__list">
                <!-- Item 1 -->
                <?php
                if (have_rows('prices_repeater')):
                    while (have_rows('prices_repeater')):
                        the_row(); ?>
                        <div class="prices__item">
                            <span class="prices__name"><?php the_sub_field('name'); ?></span>
                            <div class="prices__dots"></div>
                            <span class="prices__cost"><?php the_sub_field('cost'); ?></span>
                        </div>
                        <?php
                    endwhile;
                
                endif;
                ?>
            </div>

            <div class="prices__footer text-center">
                <p class="prices__disclaimer">
                    <?php the_field('prices_disclaimer'); ?>
                </p>
                <a href="<?php echo get_field('prices_btn')['url']; ?>" class="btn btn--primary">
                    <?php echo get_field('prices_btn')['title']; ?>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Guarantees Section -->
<section id="guarantees" class="guarantees section-padding">
    <div class="container">
        <div class="guarantees__inner">
            <div class="guarantees__info">
                <span class="section-overhead"><?php the_field('guarantees_subtitle'); ?></span>
                <h2 class="section-title text-left"><?php the_field('guarantees_title'); ?></h2>
                <p class="guarantees__text"><?php the_field('guarantees_descr'); ?></p>

                <ul class="guarantees__list">
                    <?php
                    if (have_rows('guarantees_repeater')):
                        while (have_rows('guarantees_repeater')):
                            the_row(); ?>
                            <li class="guarantees__item">
                                <div class="guarantees__icon">
                                    <?php echo get_sub_field('icon'); ?>
                                </div>
                                <div class="guarantees__content">
                                    <strong><?php the_sub_field('name'); ?></strong>
                                    <p><?php the_sub_field('descr'); ?></p>
                                </div>
                            </li>

                            <?php
                        endwhile;
                    
                    endif;
                    ?>
                </ul>
            </div>

            <div class="guarantees__partners">
                <h3 class="guarantees__subtitle"><?php the_field('partners_title'); ?></h3>
                <div class="partners-grid">
                    <?php
                    if (have_rows('partners_repeater')):
                        while (have_rows('partners_repeater')):
                            the_row(); ?>
                            <div class="partner-card"><img src="<?php echo get_sub_field('image')['url']; ?>"
                                    alt="<?php echo get_sub_field('image')['alt']; ?>">
                            </div>


                            <?php
                        endwhile;
                    
                    endif;
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Facts Section -->
<section id="facts" class="facts section-padding">
    <div class="container">
        <div class="facts-wrapper">
            <div class="facts-intro">
                <span class="section-overhead"><?php the_field('facts_subtitle'); ?></span>
                <h2 class="facts-intro__title"><?php the_field('facts_title'); ?></h2>
                <p class="facts-intro__text"><?php the_field('facts_descr'); ?></p>
                <a href="<?php echo get_field('facts_btn')['url']; ?>" class="btn btn--primary">
                    <?php echo get_field('facts_btn')['title']; ?></a>
            </div>

            <div class="facts-mosaic">
                <!-- Row 1 (2 items) -->
                <?php
                if (have_rows('facts_repeater')):
                    while (have_rows('facts_repeater')):
                        the_row(); ?>
                        <div class="fact-item">
                            <span class="fact-item__number"><?php the_sub_field('number'); ?></span>
                            <span class="fact-item__label"><?php the_sub_field('label'); ?></span>
                        </div>
                        <?php
                    endwhile;
                
                endif;
                ?>
            </div>
        </div>
    </div>
</section>

<!-- Reviews Section -->
<section id="reviews" class="reviews section-padding">
    <div class="container container--reviews">
        <div class="section-header text-center">
            <span class="section-overhead"><?php the_field('reviews_subtitle'); ?></span>
            <h2 class="section-title"><?php the_field('reviews_title'); ?></h2>
        </div>

        <div class="reviews__slider">
            <!-- Review 1 -->
            <?php
            if (have_rows('reviews_repeater')):
                while (have_rows('reviews_repeater')):
                    the_row(); ?>
                    <div class="review-card">
                        <div class="review-card__header">
                            <div class="review-card__user">
                                <span class="review-user__initial"><?php the_sub_field('initial'); ?></span>
                                <div>
                                    <h4 class="review-user__name"><?php the_sub_field('name'); ?></h4>
                                    <span class="review-user__car"><?php the_sub_field('car'); ?></span>
                                </div>
                            </div>
                            <div class="review-card__rating">
                                ★★★★★
                            </div>
                        </div>
                        <p class="review-card__text">
                            <?php the_sub_field('text'); ?>
                        </p>
                    </div>

                    <?php
                endwhile;
            
            endif;
            ?>
        </div>
</section>

<!-- FAQ Section -->
<section id="faq" class="faq section-padding">
    <div class="container">
        <div class="section-header text-center">
            <span class="section-overhead"><?php the_field('faq_subtitle'); ?></span>
            <h2 class="section-title"><?php the_field('faq_title'); ?></h2>
        </div>

        <div class="faq__wrapper">
            <!-- FAQ Item 1 -->
            <?php
            if (have_rows('faq_repeater')):
                while (have_rows('faq_repeater')):
                    the_row(); ?>
                    <div class="faq-item">
                        <button class="faq-item__header" aria-expanded="false" aria-controls="faq-content-1">
                            <span class="faq-item__title"><?php the_sub_field('title'); ?></span>
                            <div class="faq-item__icon">
                                <span></span>
                                <span></span>
                            </div>
                        </button>
                        <div id="faq-content-1" class="faq-item__content" aria-hidden="true">
                            <div class="faq-item__text">
                                <?php the_sub_field('text'); ?>
                            </div>
                        </div>
                    </div>

                    <?php
                endwhile;
            
            endif;
            ?>
        </div>
    </div>
</section>


<!-- Blog Section -->
<section id="blog" class="blog section-padding">
    <div class="container">
        <div class="section-header text-center">
            <span class="section-overhead"><?php the_field('blog_subtitle'); ?></span>
            <h2 class="section-title"><?php the_field('blog_title'); ?></h2>
        </div>
        <!-- 
        <div class="blog__categories">
            <button class="blog-category active">Все</button>
            <button class="blog-category">ТО Volvo</button>
            <button class="blog-category">Типичные поломки</button>
            <button class="blog-category">Эксплуатация</button>
            <button class="blog-category">Сезонная подготовка</button>
        </div> -->

        <div class="blog__grid">
            <!-- ДОСТАЕМ ПОСТЫ ИЗ БАЗЫ ДАННЫХ -->
            <?php
            // задаем нужные нам критерии выборки данных из БД
            $args = array(
                'posts_per_page' => 3,
                'category_name' => 'blog',
            );

            $query = new WP_Query($args);

            // Цикл
            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post(); ?>

                    <article class="blog-card" data-category="tips">
                        <div class="blog-card__image-box">
                            <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php echo get_the_title(); ?>"
                                class="blog-card__img">
                            <div class="blog-card__overlay"></div>
                            <span class="blog-card__date">
                                <?php echo get_the_date(); ?>
                            </span>
                        </div>
                        <div class="blog-card__content">
                            <span class="blog-card__tag">
                                <?php echo get_the_term_list(get_the_ID(), 'category', '', ', ', ''); ?>
                            </span>
                            <h3 class="blog-card__title">
                                <?php echo get_the_title(); ?>
                            </h3>
                            <p class="blog-card__text">
                                <?php echo get_the_excerpt(); ?>
                            </p>
                            <a href="<?php echo get_the_permalink(); ?>" class="blog-card__link">Читать далее &rarr;</a>
                        </div>
                    </article>
                    <?php
                }
            } else {
                // Постов не найдено
            }

            // Возвращаем оригинальные данные поста. Сбрасываем $post.
            wp_reset_postdata(); ?>


        </div>

        <div class="blog__footer text-center">
            <a href="<?php echo get_field('blog_btn')['url']; ?>" class="btn btn--outline">
                <?php echo get_field('blog_btn')['title']; ?>
            </a>
        </div>
    </div>
</section>

<!-- Contacts Section -->
<section id="contact" class="contacts section-padding">
    <div class="container">
        <div class="section-header text-center">
            <span class="section-overhead"><?php the_field('contacts_subtitle'); ?></span>
            <h2 class="section-title"><?php the_field('contacts_title'); ?></h2>
        </div>
        <div class="contacts__inner">
            <div class="contacts__info">
                <!-- Цикл для повторителя -->
                <?php
                if (have_rows('contacts_info')):
                    while (have_rows('contacts_info')):
                        the_row(); ?>

                        <div class="contacts__item">
                            <div class="contacts__icon">
                                <?php echo get_sub_field('icon'); ?>
                            </div>
                            <div>
                                <h4 class="contacts__label">
                                    <?php the_sub_field('label'); ?>
                                </h4>
                                <p class="contacts__text">
                                    <?php the_sub_field('text'); ?>
                                </p>
                                <p class="contacts__subtext">
                                    <?php the_sub_field('subtext'); ?>
                                </p>
                            </div>
                        </div>


                        <?php
                    endwhile;
                
                endif;
                ?>

                <!--  -->
            </div>

            <div class="contacts__map">
                <!-- Yandex Map Placeholder -->
                <?php echo get_field('contacts_map'); ?>
            </div>
        </div>
    </div>
</section>



<?php
get_footer();