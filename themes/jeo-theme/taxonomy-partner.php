<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Newspack
 */

get_header();
?>
	
		<section id="primary" class="content-area custom-archive">
			<header class="page-header">
				<span>
					<h1 class="page-title article-section-title category-header">
						<span class="page-description"><?php echo single_term_title() ?></span>
					</h1>
					<?php if ( '' !== get_the_archive_description() ) : ?>
						<div class="taxonomy-description">
							<?php echo wp_kses_post( wpautop( get_the_archive_description() ) ); ?>
						</div>
					<?php endif; ?>
				</span>

			</header><!-- .page-header -->


			<?php do_action( 'before_archive_posts' ); ?>

			<main id="main" class="site-main">

			<?php
			if ( have_posts() ) :
				$post_count = 0;
				?>

				<?php
				// Start the Loop.
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/content/content', 'excerpt' );

					// End the loop.
				endwhile;

				// Previous/next page navigation.
				echo (get_theme_mod('pagination_style', 'rectangle') == 'circle'? '<div class="circle">' : '<div class="rectangle">');
				newspack_the_posts_navigation();
				echo '</div>';

				// If no content, include the "No posts found" template.
			else :
				get_template_part( 'template-parts/content/content', 'none' );

			endif;
			?>
			</main><!-- #main -->
			<aside class="category-page-sidebar">
    			<div class="content">
					<?php dynamic_sidebar('category_page_sidebar') ?>
				</div>
			</aside>
		</section><!-- #primary -->
<?php
get_footer();
