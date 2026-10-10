<footer id="main-footer" class="footer">
	<div class="container">
		<div class="footer__inner">
			<div class="footer__col footer__col--info">
				<a href="/" class="footer__logo-link">
					<img src="<?php echo get_field('footer_logo', 'option')['url']; ?>"
						alt="<?php echo get_field('footer_logo', 'option')['alt']; ?>" class="footer__logo-img">
				</a>
				<p class="footer__desc">
					<?php echo get_field('footer_description', 'option'); ?>
				</p>
			</div>

			<div class="footer__col">
				<h4 class="footer__title">Навигация</h4>
				<?php wp_nav_menu([
					'theme_location' => 'footer',
					'menu' => '',
					'container' => 'ul',
					'container_class' => 'footer__nav',
					'container_id' => '',
					'menu_class' => 'footer__nav',
					'menu_id' => '',
					'echo' => true,
					'fallback_cb' => 'wp_page_menu',
					'before' => '',
					'after' => '',
					'link_before' => '',
					'link_after' => '',
					'depth' => 0,
					'walker' => '',
				]); ?>
				<!-- <ul class="footer__nav">
					<li><a href="#services">Услуги</a></li>
					<li><a href="#about">О компании</a></li>
					<li><a href="#blog">Блог</a></li>
					<li><a href="#contact">Контакты</a></li>
				</ul> -->
			</div>

			<div class="footer__col">
				<h4 class="footer__title">Контакты</h4>
				<ul class="footer__contacts">
					<li>
						<?php
						$footer_phone = get_field('footer_phone', 'option');
						$raw_url = !empty($footer_phone['url']) ? $footer_phone['url'] : '+74957900949';
						$clean_url = 'tel:' . ltrim(str_replace('tel:', '', $raw_url), ':');
						$phone_title = !empty($footer_phone['title']) ? $footer_phone['title'] : '+7 (495) 790-09-49';
						?>
						<a href="<?php echo esc_attr($clean_url); ?>" class="footer__phone">
							<?php echo esc_html($phone_title); ?></a>
					</li>
					<li class="footer__address"><?php the_field('footer_address', 'option'); ?></li>
					<li class="footer__worktime"><?php the_field('footer_worktime', 'option'); ?></li>
				</ul>
			</div>
		</div>

		<div class="footer__bottom">
			<div class="footer__copyright">
				&copy; <?php echo date('Y'); ?> <?php the_field('footer_copyright', 'option'); ?>
			</div>
			<div class="footer__legal">
				<a href="#">Политика конфиденциальности</a>
				<a href="#">Согласие на обработку</a>
			</div>
		</div>
	</div>
</footer>

<!-- Script -->
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

<!-- Modal Booking Window -->
<div id="bookingModal" class="modal" aria-hidden="true" role="dialog" aria-labelledby="modalTitle">
	<div class="modal__overlay" data-modal-close></div>
	<div class="modal__dialog">
		<button class="modal__close" data-modal-close aria-label="Закрыть окно">&times;</button>
		<div class="modal__content" id="modalFormContainer">
			<span class="modal__overhead">ЗАПИСЬ НА СЕРВИС</span>
			<h3 class="modal__title" id="modalTitle">Записаться на диагностику и ремонт</h3>
			<p class="modal__desc">Оставьте номер телефона, и мастер-приемщик свяжется с вами в течение 10 минут для согласования времени визита.</p>
			
			<form class="modal__form booking-form" data-form-type="ajax">
				<input type="hidden" name="action" value="vlprime_booking">
				<div class="modal__form-group">
					<input type="text" name="name" placeholder="Ваше имя *" class="form-input" required>
				</div>
				<div class="modal__form-group">
					<input type="tel" name="phone" placeholder="+7 (___) ___-__-__ *" class="form-input" required>
				</div>
				<div class="modal__form-group">
					<select name="model" class="form-select">
						<option value="" disabled selected>Выберите модель Volvo</option>
						<option value="XC90">Volvo XC90</option>
						<option value="XC70">Volvo XC70</option>
						<option value="XC60">Volvo XC60</option>
						<option value="XC40">Volvo XC40</option>
						<option value="S90">Volvo S90</option>
						<option value="S80">Volvo S80</option>
						<option value="S60">Volvo S60</option>
						<option value="V90">Volvo V90</option>
						<option value="V60">Volvo V60</option>
						<option value="Other">Другая модель</option>
					</select>
				</div>
				<button type="submit" class="btn btn--primary modal__submit-btn">Отправить заявку</button>
				<p class="form-policy">Нажимая кнопку, вы соглашаетесь с условиями обработки данных</p>
			</form>
		</div>

		<div class="modal__success" id="modalSuccessContainer" style="display: none;">
			<div class="modal__success-icon">
				<svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
					<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
					<polyline points="22 4 12 14.01 9 11.01"></polyline>
				</svg>
			</div>
			<h3 class="modal__title">Спасибо за заявку!</h3>
			<p class="modal__desc">Мы получили ваши данные. Мастер-приемщик свяжется с вами в течение 10 минут.</p>
			<div class="modal__success-actions">
				<button type="button" class="btn btn--secondary" data-modal-close>Закрыть</button>
				<a href="https://t.me/+79266262662" target="_blank" class="btn btn--primary">Написать в Telegram</a>
			</div>
		</div>
	</div>
</div>

<?php wp_footer(); ?>

</body>

</html>