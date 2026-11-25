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
<?php
	$vlp_title = wp_get_document_title();
	$vlp_url = home_url('/');
	$vlp_img = get_template_directory_uri() . '/assets/img/background_hero.png';
	$vlp_desc = 'Специализированный автосервис Volvo в Москве (ул. Ермакова Роща, 7А). Диагностика VIDA, плановое ТО, ремонт ДВС, АКПП, муфт Haldex и угловых передач с гарантией.';
	$vlp_og_type = 'website';

	if (is_front_page()) {
		$vlp_title = 'Специализированный сервис Volvo VL Prime в Москве';
	} elseif (is_page('uslugi')) {
		$vlp_url = get_permalink();
		$vlp_title = 'Услуги и онлайн-калькулятор ремонта Volvo | VL Prime';
		$vlp_desc = 'Услуги и расчёт стоимости ремонта Volvo в техцентре VL Prime в Москве: ТО, диагностика VIDA, замена ГРМ, обслуживание Haldex, замена втулки угловой передачи, ремонт АКПП Aisin.';
	} elseif (is_category('blog')) {
		$vlp_url = get_category_link(get_queried_object_id());
		$vlp_title = 'Блог техцентра VL Prime: статьи по ремонту и обслуживанию Volvo';
		$vlp_desc = 'Технические статьи мастеров VL Prime: регламент замены ГРМ, обслуживание муфты Haldex, мойка радиаторов, замена масла АКПП и решение типовых проблем Volvo.';
	} elseif (is_category('gallery')) {
		$vlp_url = get_category_link(get_queried_object_id());
		$vlp_title = 'Галерея работ и кейсов ремонта Volvo | VL Prime';
		$vlp_desc = 'Реальные кейсы ремонта автомобилей Volvo в цехе VL Prime с дефектовкой, этапами работ и детальными сметами.';
	} elseif (is_singular()) {
		$vlp_url = get_permalink();
		$vlp_og_type = is_single() ? 'article' : 'website';
		$vlp_title = get_the_title() . ' | VL Prime';
		$raw_excerpt = get_the_excerpt();
		if (empty($raw_excerpt)) {
			$raw_excerpt = wp_strip_all_tags(get_post_field('post_content', get_queried_object_id()));
		}
		$clean_desc = trim(preg_replace('/\s+/u', ' ', html_entity_decode(wp_strip_all_tags($raw_excerpt), ENT_QUOTES, 'UTF-8')));
		if (!empty($clean_desc)) {
			$vlp_desc = mb_substr($clean_desc, 0, 160);
			if (mb_strlen($clean_desc) > 160) {
				$vlp_desc = preg_replace('/\s+\S*$/u', '', $vlp_desc) . '...';
			}
		}
		$thumb = get_the_post_thumbnail_url(get_queried_object_id(), 'large');
		if (!empty($thumb)) {
			$vlp_img = function_exists('vlprime_img_url') ? vlprime_img_url($thumb) : $thumb;
		}
	}
	?>
	<meta name="description" content="<?php echo esc_attr($vlp_desc); ?>">
	<link rel="icon" href="<?php echo esc_url(home_url('/favicon.svg')); ?>" type="image/svg+xml">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

	<!-- Open Graph / Meta -->
	<meta property="og:locale" content="ru_RU">
	<meta property="og:type" content="<?php echo esc_attr($vlp_og_type); ?>">
	<meta property="og:site_name" content="VL Prime">
	<meta property="og:title" content="<?php echo esc_attr($vlp_title); ?>">
	<meta property="og:description" content="<?php echo esc_attr($vlp_desc); ?>">
	<meta property="og:image" content="<?php echo esc_url($vlp_img); ?>">
	<meta property="og:url" content="<?php echo esc_url($vlp_url); ?>">

	<!-- Schema.org Microdata (AutoRepair) -->
	<script type="application/ld+json">
	{
		"@context": "https://schema.org",
		"@type": "AutoRepair",
		"name": "VL Prime — Автосервис Volvo",
		"description": "Профессиональный специализированный сервис Volvo в Москве. Компьютерная диагностика VIDA, ТО, ремонт ДВС, АКПП, муфт Haldex и оригинальные запчасти с гарантией.",
		"image": "<?php echo get_template_directory_uri(); ?>/assets/icon/logo.svg",
		"url": "https://vlprime.ru",
		"telephone": "+74957900949",
		"priceRange": "$$",
		"currenciesAccepted": "RUB",
		"paymentAccepted": "Cash, Credit Card, Bank Transfer",
		"areaServed": "Москва и Московская область",
		"hasMap": "https://yandex.ru/maps/-/CDuXeH0g",
		"address": {
			"@type": "PostalAddress",
			"streetAddress": "Ермакова роща, 7А, стр.1",
			"addressLocality": "Москва",
			"addressRegion": "Москва",
			"postalCode": "123007",
			"addressCountry": "RU"
		},
		"geo": {
			"@type": "GeoCoordinates",
			"latitude": 55.766723,
			"longitude": 37.535041
		},
		"aggregateRating": {
			"@type": "AggregateRating",
			"ratingValue": "4.9",
			"bestRating": "5",
			"ratingCount": "184"
		},
		"openingHoursSpecification": {
			"@type": "OpeningHoursSpecification",
			"dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
			"opens": "09:00",
			"closes": "21:00"
		}
	}
	</script>

	<!-- Yandex.Metrika counter (VL Prime / Yandex Direct) -->
	<script type="text/javascript">
	   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
	   m[i].l=1*new Date();
	   for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
	   k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
	   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

	   ym(114435196, "init", {
			clickmap:true,
			trackLinks:true,
			accurateTrackBounce:true,
			webvisor:true
	   });
	   ym(95212734, "init", {
			clickmap:true,
			trackLinks:true,
			accurateTrackBounce:true,
			webvisor:false
	   });
	</script>
	<noscript><div><img src="https://mc.yandex.ru/watch/95212734" style="position:absolute; left:-9999px;" alt="" /><img src="https://mc.yandex.ru/watch/114435196" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
	<!-- /Yandex.Metrika counter -->

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
				<a href="<?php echo esc_url(home_url('/')); ?>" class="logo" aria-label="VL Prime Главная">
					<img src="<?php echo $logo_url; ?>" alt="<?php echo $logo_alt; ?>" class="logo__img" width="129" height="51">
				</a>
				<div class="header__socials">
					<?php
					if (have_rows('header_socials', 'option')):
						while (have_rows('header_socials', 'option')):
							the_row(); 
							$social_link = get_sub_field('link');
							$social_icon = get_sub_field('icon');
							if (!empty($social_link['url'])): 
								$link_url = $social_link['url'];
								if (strpos($link_url, 'tel:') !== false) {
									$link_url = 'tel:+74957900949';
								} elseif (strpos($link_url, 't.me') !== false) {
									$link_url = 'https://t.me/+79652044056';
								}

								$icon_url = '';
								if (is_array($social_icon) && !empty($social_icon['url'])) {
									$icon_url = $social_icon['url'];
								} elseif (is_string($social_icon) && !empty($social_icon)) {
									$icon_url = $social_icon;
								}

								// Safe fallback to native theme icons
								if (empty($icon_url)) {
									if (strpos($link_url, 'tel:') !== false) {
										$icon_url = get_template_directory_uri() . '/assets/icon/social/phone.svg';
									} elseif (strpos($link_url, 't.me') !== false) {
										$icon_url = get_template_directory_uri() . '/assets/icon/social/telegram.svg';
									} elseif (strpos($link_url, 'wa.me') !== false) {
										$icon_url = get_template_directory_uri() . '/assets/icon/social/whatsapp.svg';
									} else {
										$icon_url = '';
									}
								}

								// Skip MAX icon or placeholder links
								if (empty($link_url) || $link_url === '#' || strpos($icon_url, 'max-circle') !== false) {
									continue;
								}

								$social_name = !empty($social_link['title']) ? esc_attr($social_link['title']) : 'Контакт';
								if (strpos($link_url, 'tel:') !== false) {
									$social_name = 'Позвонить';
								} elseif (strpos($link_url, 't.me') !== false) {
									$social_name = 'Telegram';
								}
							?>
								<a href="<?php echo esc_url($link_url); ?>" class="social-link"
									aria-label="<?php echo $social_name; ?>"
									style="--icon-url: url('<?php echo esc_url($icon_url); ?>')"></a>
							<?php endif;
						endwhile;
					else: ?>
						<a href="tel:+74957900949" class="social-link" aria-label="Позвонить"
							style="--icon-url: url('<?php echo get_template_directory_uri(); ?>/assets/icon/social/phone.svg')"></a>
						<a href="https://t.me/+79652044056" class="social-link" aria-label="Telegram"
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