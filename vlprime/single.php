<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package vlprime
 */

get_header();
?>

<!-- Page Hero (Reusing .hero from index for consistency) -->


<!-- Article Content -->
<section class="article-page section-padding">
	<div class="container">
		<div class="article-content">
			<a href="<?php echo esc_url(get_category_link(get_category_by_slug('blog'))); ?>" class="back-link">&larr; Назад к статьям</a>

			<header class="article-header">
				<div class="article-meta">
					<span class="blog-card__tag">
						<?php echo get_the_category_list(', '); ?>
					</span>
					<span class="article-date"><?php echo get_the_date(); ?></span>
				</div>
				<h1 class="article-title"><?php the_title(); ?></h1>
			</header>

			<div class="article-body">
				<img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>"
					class="article-main-image">

				<?php
				the_content();
				?>

				<div class="article-footer">
					<a href="/" class="btn btn--primary">Вернуться</a>
				</div>
			</div>
		</div>
</section>


<?php
get_footer();
