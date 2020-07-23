<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Newspack
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content">
		<?php
		the_content(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'newspack' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			)
		);

		if(get_post_meta(get_the_ID(), 'enable-post-erratum', true) ) { ?>
			<div class="sorry-said-wrong" id="erratum">
				<div class="wrong-title">
					<?= __('Sorry, We said wrong', 'jeo') ?>
				</div>
				<p class="wrong-content">
					<?= get_post_meta(get_the_ID(), 'post-erratum', true) ?>
				</p>
			</div>
		<?php }

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'newspack' ),
				'after'  => '</div>',
			)
		);
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php newspack_entry_footer(); ?>
	</footer><!-- .entry-footer -->

	<?php if ( ! is_singular( 'attachment' )  && get_post_meta(get_the_ID(), 'author-bio-display', true)) : ?>
		<?php get_template_part( 'template-parts/post/author', 'bio' ); ?>
	<?php endif; ?>

	<?php if (  is_active_sidebar( 'article-2' ) && is_single() ) : ?>
		<?php dynamic_sidebar( 'article-2' );?>
	<?php endif; ?>

</article><!-- #post-${ID} -->
