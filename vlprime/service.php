<?php
/*
Template Name: Шаблон страницы УСЛУГИ
*/
get_header();
?>

<!-- Hero Section -->
<section class="service-hero">
    <div class="hero__overlay"></div>
    <div class="container">
        <div class="service-hero__content">
            <h1 class="service-hero__title">Наши услуги</h1>
            <p class="service-hero__subtitle">Полный цикл обслуживания вашего Volvo.<br>От планового ТО до сложного
                ремонта.</p>
            <div class="service-hero__actions">
                <a href="#booking" class="btn btn--primary">Записаться</a>
            </div>
        </div>
    </div>
</section>

<!-- Services Grid with Calculators -->
<section class="section-padding bg-darker" id="services-catalog">
    <div class="container">

        <!-- Block -->
        <?php
        if (have_rows('service_block')):
            while (have_rows('service_block')):
                the_row(); ?>
                <div class="service-block" id="<?php echo get_sub_field('id'); ?>">
                    <div class="service-block__header">
                        <div class="service-block__icon">
                            <?php echo get_sub_field('icon'); ?>
                        </div>
                        <div class="service-block__info">
                            <h2 class="service-block__title"><?php the_sub_field('title'); ?></h2>
                            <p class="service-block__desc"><?php the_sub_field('description'); ?></p>
                        </div>
                    </div>
                    <div class="service-calc">
                        <h3 class="service-calc__title">Рассчитать стоимость</h3>
                        <div class="service-calc__options">
                            <!-- Цикл для повторителя -->
                            <?php
                            if (have_rows('calc_services')):
                                while (have_rows('calc_services')):
                                    the_row(); ?>
                                    <?php $price = get_sub_field('price'); ?>
                                    <label class="calc-option">
                                        <input type="checkbox" class="calc-checkbox" data-price="<?php echo $price; ?>"
                                            data-service="<?php the_sub_field('service'); ?>">
                                        <span class="calc-option__box"></span>
                                        <span class="calc-option__text"><?php the_sub_field('service'); ?></span>
                                        <span class="calc-option__price">от <?php echo $price; ?> ₽</span>
                                    </label>

                                    <?php
                                endwhile;
                            
                            endif;
                            ?>
                        </div>
                        <div class="service-calc__footer">
                            <div class="calc-total">
                                <span class="calc-total__label">Итого:</span>
                                <span class="calc-total__value">0 ₽</span>
                            </div>
                            <button class="btn btn--primary btn--sm calc-book-btn" disabled>Записаться</button>
                        </div>
                    </div>
                </div>

                <?php
            endwhile;
        
        endif;
        ?>

    </div>
</section>

<!-- Global Summary Block -->
<section id="service-summary" class="section-padding bg-darker" style="padding-top: 0; padding-bottom: 60px;">
    <div class="container">
        <div class="summary-card">
            <div class="summary-header">
                <h3 class="summary-title">Ваш выбор</h3>
                <p class="summary-desc">Отмеченные услуги из всех категорий</p>
            </div>

            <div class="summary-list" id="global-summary-list">
                <div class="summary-empty">Ничего не выбрано</div>
            </div>

            <div class="summary-footer">
                <div class="summary-total">
                    <span class="summary-total__label">Общая стоимость:</span>
                    <span class="summary-total__value" id="global-total-value">0 ₽</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 10. Booking Block -->
<section id="booking" class="section-padding booking-section">
    <div class="container">
        <div class="booking-wrapper">
            <div class="booking-text">
                <h2 class="section-title">Запишитесь на ремонт</h2>
                <p>Оставьте заявку сейчас и получите бесплатную диагностику подвески при ремонте АКПП.</p>
            </div>
            <form class="booking-form">
                <input type="text" placeholder="Ваше имя" class="form-input">
                <input type="tel" placeholder="Телефон" class="form-input">
                <select class="form-select">
                    <option value="" disabled selected>Выберите модель</option>
                    <?php
                    if (have_rows('models')):
                        while (have_rows('models')):
                            the_row(); ?>
                            <option value="<?php the_sub_field('model'); ?>">Volvo <?php the_sub_field('model'); ?></option>
                            <?php
                        endwhile;
                    else:
                        $default_models = ['XC90', 'XC70', 'XC60', 'XC40', 'S90', 'S80', 'S60', 'V90', 'V60'];
                        foreach ($default_models as $m): ?>
                            <option value="<?php echo esc_attr($m); ?>">Volvo <?php echo esc_html($m); ?></option>
                        <?php endforeach;
                    endif;
                    ?>
                    <option value="Other">Другая</option>
                </select>
                <button type="submit" class="btn btn--primary">Отправить заявку</button>
                <p class="form-policy">Нажимая кнопку, вы соглашаетесь с условиями обработки данных</p>
            </form>
        </div>
    </div>
</section>


<?php
get_footer();