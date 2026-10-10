<?php
/*
Template Name: Шаблон БЛОГА страницы
*/
get_header();
?>
<section class="hero hero--blog">
    <div class="hero__overlay"></div>
    <div class="container">
        <div class="hero__content text-center" style="align-items: center; text-align: center; max-width: 100%;">
            <h1 class="hero__title">НАШ БЛОГ</h1>
            <p class="hero__subtitle">Новости, полезные советы и обзоры из мира Volvo</p>
        </div>
    </div>
</section>
<!-- Blog Content -->
<section class="blog-page section-padding">
    <div class="container">
        <!-- Filters -->
        <!-- <div class="blog__categories blog-filters">
            <button class="blog-category active" data-filter="all">Все</button>
            <button class="blog-category" data-filter="news">Новости</button>
            <button class="blog-category" data-filter="tips">Советы</button>
            <button class="blog-category" data-filter="reviews">Обзоры</button>
            <button class="blog-category" data-filter="service">Жизнь сервиса</button>
        </div> -->

        <!-- Grid -->
        <div class="blog__grid">
            <!-- ДОСТАЕМ ПОСТЫ ИЗ БАЗЫ ДАННЫХ -->
            <?php
            // задаем нужные нам критерии выборки данных из БД
            $args = array(
                'posts_per_page' => 12,
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
    </div>
</section>

<?php
get_footer();