<?php
/*
Template Name: Шаблон ГАЛЕРЕЯ НАШИ РАБОТЫ страницы
*/
get_header();
?>

<!-- Page Hero -->
<section class="hero hero--blog">
    <div class="hero__overlay"></div>
    <div class="container">
        <div class="hero__content text-center" style="align-items: center; text-align: center; max-width: 100%;">
            <h1 class="hero__title">НАШИ РАБОТЫ</h1>
            <p class="hero__subtitle">Примеры выполненных ремонтов и обслуживания автомобилей Volvo</p>
        </div>
    </div>
</section>

<!-- Gallery Content -->
<section class="blog-page section-padding">
    <div class="container">
        <!-- Filters -->
        <!-- <div class="blog__categories blog-filters">
            <button class="blog-category active" data-filter="all">Все</button>
            <button class="blog-category" data-filter="engine">Двигатель</button>
            <button class="blog-category" data-filter="gearbox">АКПП</button>
            <button class="blog-category" data-filter="suspension">Подвеска</button>
            <button class="blog-category" data-filter="maintenance">ТО</button>
        </div> -->

        <!-- Grid -->
        <div class="blog__grid">
            <!-- ДОСТАЕМ ПОСТЫ ИЗ БАЗЫ ДАННЫХ -->
            <?php
            // задаем нужные нам критерии выборки данных из БД
            $args = array(
                'posts_per_page' => 6,
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
                            <a href="<?php echo get_the_permalink(); ?>" class="blog-card__link">Смотреть</a>
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
    </div>
</section>
<?php
get_footer();