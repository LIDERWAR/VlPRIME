<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package vlprime
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico" type="image/x-icon">

	<!-- Open Graph / Meta -->
	<meta property="og:locale" content="ru_RU">
	<meta property="og:type" content="website">
	<meta property="og:site_name" content="VL Prime">
	<meta property="og:title" content="VL Prime — Премиальный сервис Volvo в Москве">
	<meta property="og:description" content="Профессиональный сервис и ТО автомобилей Volvo в Москве. Диагностика VIDA, оригинальные запчасти, гарантия.">
	<meta property="og:image" content="<?php echo get_template_directory_uri(); ?>/assets/img/background_hero.png">
	<meta property="og:url" content="<?php echo esc_url(home_url('/')); ?>">

	<!-- Schema.org Microdata (AutoRepair) -->
	<script type="application/ld+json">
	{
		"@context": "https://schema.org",
		"@type": "AutoRepair",
		"name": "VL Prime — Автосервис Volvo",
		"description": "Профессиональный сервис Volvo в Москве. Ремонт, ТО, оригинальные запчасти.",
		"image": "<?php echo get_template_directory_uri(); ?>/assets/icon/logo.svg",
		"url": "https://vlprime.ru",
		"telephone": "+74957900949",
		"priceRange": "$$",
		"address": {
			"@type": "PostalAddress",
			"streetAddress": "Ермакова роща, 7А, стр.1",
			"addressLocality": "Москва",
			"addressCountry": "RU"
		},
		"openingHoursSpecification": {
			"@type": "OpeningHoursSpecification",
			"dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
			"opens": "09:00",
			"closes": "21:00"
		}
	}
	</script>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>

	<!-- Header -->
	<header class="header">
		<div class="container header__container">
			<div class="header__left">
				<?php 
				$header_logo = get_field('header_logo', 'option');
				$logo_url = (!empty($header_logo) && !empty($header_logo['url'])) ? esc_url($header_logo['url']) : get_template_directory_uri() . '/assets/icon/logo.svg';
				$logo_alt = (!empty($header_logo) && !empty($header_logo['alt'])) ? esc_attr($header_logo['alt']) : 'VL Prime';
				?>
				<a href="<?php echo esc_url(home_url('/')); ?>" class="logo">
					<img src="<?php echo $logo_url; ?>" alt="<?php echo $logo_alt; ?>" class="logo__img">
				</a>
				<div class="header__socials">
					<?php
					if (have_rows('header_socials', 'option')):
						while (have_rows('header_socials', 'option')):
							the_row(); 
							$social_link = get_sub_field('link');
							$social_icon = get_sub_field('icon');
							if (!empty($social_link['url'])): ?>
								<a href="<?php echo esc_url($social_link['url']); ?>" class="social-link"
									style="--icon-url: url('<?php echo esc_url($social_icon); ?>')"></a>
							<?php endif;
						endwhile;
					else: ?>
						<a href="https://wa.me/79096249289" class="social-link" aria-label="WhatsApp"
							style="--icon-url: url('<?php echo get_template_directory_uri(); ?>/assets/icon/social/whatsapp.svg')"></a>
						<a href="https://t.me/+79096249289" class="social-link" aria-label="Telegram"
							style="--icon-url: url('<?php echo get_template_directory_uri(); ?>/assets/icon/social/telegram.svg')"></a>
					<?php endif; ?>
				</div>
			</div>


			<?php wp_nav_menu([
				'theme_location' => 'header',
				'menu' => '',
				'container' => 'nav',
				'container_class' => 'nav',
				'container_id' => '',
				'menu_class' => 'nav__list',
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

			<button class="burger-menu" aria-label="Открыть меню">
				<span></span>
				<span></span>
				<span></span>
			</button>
		</div>
	</header>