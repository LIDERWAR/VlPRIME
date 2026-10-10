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



<?php wp_footer(); ?>

</body>

</html>