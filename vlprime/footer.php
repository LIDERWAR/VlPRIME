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
				<a href="#" data-modal-target="privacyModal">Политика конфиденциальности</a>
				<a href="#" data-modal-target="privacyModal">Согласие на обработку</a>
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
<div id="bookingModal" class="modal" style="display: none;" aria-hidden="true" role="dialog" aria-labelledby="modalTitle">
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
				<p class="form-policy">Нажимая кнопку, вы соглашаетесь с <a href="#" data-modal-target="privacyModal" style="text-decoration: underline; color: inherit;">условиями обработки персональных данных</a></p>
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
				<a id="modalTgLink" href="https://t.me/+79096249289" target="_blank" class="btn btn--primary">Написать в Telegram (+7 909 624-92-89)</a>
				<a id="modalWaLink" href="https://wa.me/79096249289" target="_blank" class="btn btn--secondary">Написать в WhatsApp</a>
				<button type="button" class="btn btn--secondary" data-modal-close>Закрыть окно</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal Privacy Policy (152-ФЗ) -->
<div id="privacyModal" class="modal" style="display: none;" aria-hidden="true" role="dialog" aria-labelledby="privacyTitle">
	<div class="modal__overlay" data-modal-close></div>
	<div class="modal__dialog" style="max-width: 650px; max-height: 85vh; overflow-y: auto;">
		<button class="modal__close" data-modal-close aria-label="Закрыть окно">&times;</button>
		<div class="modal__content" style="padding: 24px; text-align: left;">
			<span class="modal__overhead">КОНФИДЕНЦИАЛЬНОСТЬ</span>
			<h3 class="modal__title" id="privacyTitle" style="font-size: 20px; margin-bottom: 14px;">Политика конфиденциальности и согласие на обработку персональных данных</h3>
			<div class="modal__desc" style="font-size: 13px; line-height: 1.6; color: var(--color-text-muted); margin-bottom: 20px;">
				<p><strong>1. Общие положения</strong><br>
				Настоящая Политика обработки персональных данных составлена в соответствии с требованиями Федерального закона от 27.07.2006 № 152-ФЗ «О персональных данных» и определяет порядок обработки и меры по обеспечению безопасности данных клиентов специализированного сервиса Volvo «VL Prime» (далее — Оператор).</p>
				
				<p style="margin-top: 10px;"><strong>2. Цели обработки данных</strong><br>
				Оператор обрабатывает персональные данные (имя, контактный номер телефона, марка и модель автомобиля) исключительно в целях:<br>
				&bull; Приема и обработки заявок на сервисное обслуживание, диагностику и ремонт автомобилей Volvo;<br>
				&bull; Расчета предварительной стоимости работ и запчастей;<br>
				&bull; Согласования времени визита в сервисный центр и информирования о готовности автомобиля.</p>

				<p style="margin-top: 10px;"><strong>3. Защита информации</strong><br>
				Оператор обеспечивает конфиденциальность предоставленных данных. Персональные данные не передаются третьим лицам и не распространяются без явного согласия клиента, кроме случаев, прямо предусмотренных законодательством РФ.</p>

				<p style="margin-top: 10px;"><strong>4. Контакты Оператора</strong><br>
				По любым вопросам обработки данных клиент может обратиться по телефону <strong>+7 (495) 790-09-49</strong> или по адресу: г. Москва, Ермакова роща, 7А, стр. 1.</p>
			</div>
			<button type="button" class="btn btn--primary" style="width: 100%;" data-modal-close>Понятно, закрыть</button>
		</div>
	</div>
</div>

<!-- Mobile Sticky Action Bar (Быстрая связь для мобильных) -->
<div class="mobile-sticky-bar">
	<a href="tel:+74957900949" class="mobile-sticky-bar__item mobile-sticky-bar__item--call">
		<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
		<span>Позвонить</span>
	</a>
	<a href="https://wa.me/79096249289" target="_blank" rel="noopener" class="mobile-sticky-bar__item mobile-sticky-bar__item--wa">
		<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91C2.13 13.66 2.59 15.36 3.45 16.86L2.05 22L7.3 20.62C8.75 21.41 10.38 21.83 12.04 21.83C17.5 21.83 21.95 17.38 21.95 11.92C21.95 9.27 20.92 6.78 19.05 4.91C17.18 3.03 14.69 2 12.04 2M12.05 3.67C14.25 3.67 16.31 4.53 17.87 6.09C19.42 7.65 20.28 9.72 20.28 11.92C20.28 16.46 16.58 20.15 12.04 20.15C10.56 20.15 9.11 19.76 7.85 19L7.55 18.83L4.44 19.65L5.27 16.61L5.09 16.31C4.28 15.01 3.81 13.48 3.81 11.91C3.81 7.37 7.5 3.67 12.05 3.67M9.53 7.34C9.36 7.34 9.09 7.4 8.87 7.65C8.65 7.89 8.02 8.48 8.02 9.7C8.02 10.92 8.91 12.1 9.03 12.26C9.15 12.42 10.74 14.88 13.2 15.94C15.24 16.82 15.66 16.65 16.1 16.61C16.55 16.57 17.54 16.02 17.75 15.44C17.95 14.86 17.95 14.36 17.89 14.26C17.83 14.16 17.66 14.1 17.41 13.98C17.16 13.86 15.94 13.26 15.71 13.18C15.49 13.09 15.32 13.05 15.16 13.3C14.99 13.55 14.52 14.1 14.38 14.26C14.24 14.43 14.1 14.45 13.85 14.33C13.6 14.21 12.8 13.94 11.85 13.1C11.11 12.44 10.61 11.63 10.47 11.38C10.33 11.13 10.45 11 10.58 10.87C10.69 10.76 10.83 10.58 10.95 10.44C11.08 10.3 11.12 10.2 11.2 10.03C11.28 9.87 11.24 9.72 11.18 9.6C11.12 9.48 10.63 8.28 10.42 7.79C10.22 7.31 10.02 7.37 9.86 7.36C9.72 7.35 9.53 7.34 9.53 7.34Z"></path></svg>
		<span>WhatsApp</span>
	</a>
	<a href="https://t.me/+79096249289" target="_blank" rel="noopener" class="mobile-sticky-bar__item mobile-sticky-bar__item--tg">
		<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.8c-.15 1.58-.8 5.42-1.13 7.19-.14.75-.42 1-.68 1.03-.58.05-1.02-.38-1.58-.75-.88-.58-1.38-.94-2.23-1.5-.99-.65-.35-1.01.22-1.59.15-.15 2.71-2.48 2.76-2.69a.2.2 0 00-.05-.18c-.06-.05-.14-.03-.21-.02-.09.02-1.49.95-4.22 2.79-.4.27-.76.41-1.08.4-.36-.01-1.04-.2-1.55-.37-.63-.2-1.12-.31-1.08-.66.02-.18.27-.36.74-.55 2.92-1.27 4.86-2.11 5.83-2.51 2.78-1.16 3.35-1.36 3.73-1.36.08 0 .27.02.39.12.1.08.13.19.14.27-.01.06.01.24 0 .38z"></path></svg>
		<span>Telegram</span>
	</a>
	<a href="#bookingModal" data-modal-open="bookingModal" class="mobile-sticky-bar__item mobile-sticky-bar__item--book">
		<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
		<span>Запись</span>
	</a>
</div>

<?php wp_footer(); ?>

</body>

</html>