<?php

/**
 * Displays the post header
 *
 * @package Newspack
 */

$discussion = !is_page() && newspack_can_show_post_thumbnail() ? newspack_get_discussion_data() : null;
if (!get_query_var('model') || get_query_var('model') !== 'video') :
	if (is_singular()) : ?>
		<?php
		if (!is_page()) :
			newspack_categories();
		endif;
		?>
		<?php
		$subtitle = get_post_meta($post->ID, 'newspack_post_subtitle', true);
		?>

		
		
		<div class="wrapper-entry-title">
			<h1 class="entry-title <?php echo $subtitle ? 'entry-title--with-subtitle' : ''; ?>">
				<?php echo wp_kses_post(get_the_title()); ?>
			</h1>
		</div>
		<?php if ($subtitle) : ?>
			<div class="newspack-post-subtitle">
				<?php echo esc_html($subtitle); ?>
			</div>
		<?php endif; ?>

	<?php else : ?>
		<h2 class="entry-title">
			<a href="<?php the_permalink(); ?>" rel="bookmark">
				<?php echo wp_kses_post(get_the_title()); ?>
			</a>
		</h2>
	<?php endif; ?>

	<?php if (!is_page() && 'behind' !== newspack_featured_image_position() && !get_query_var('hide_post_meta')) : ?>
		<div class="entry-subhead">
		<?php 
			$terms = get_the_terms( $post->ID , 'partner' );
			$story_url = 'http://www.google.com';//get_post_meta($post->ID, 'url', true);
			var_dump($terms);
			if (!is_wp_error($terms)):?>
				<div class="publishers">
					<?php foreach ( $terms as $term ) {?>
						<span class="publisher-name">
							<?php echo esc_html__('By', 'newspack'); ?>
							<a href="<?= $story_url ?>" >
								<i class="fas fa-sync-alt publisher-icon"></i>
								<?php echo $term->name; ?>
							</a>
						</span>
					<?php }?>
				</div>
			<?php endif;?>
			<div class="entry-meta">
				<?php if (get_post_meta(get_the_ID(), 'author-bio-display', true) && empty( $terms )) : ?>
					<?php newspack_posted_by(); ?>
				<?php endif; ?>
				<div></div>
				<?php newspack_posted_on(); ?>
			</div><!-- .meta-info -->
			
			
			<?php
			// Display Jetpack Share icons, if enabled
			if (function_exists('sharing_display')) {
				sharing_display('', true);
			}
			?>
		</div>
		
		<?php if('large' == newspack_featured_image_position() || 'small' == newspack_featured_image_position()): ?>
			<?php if(has_excerpt()): ?>
				<h1 class="post-excerpt">
					<?php the_excerpt(); ?>
				</h1>
			<?php endif ?>
		<?php endif; ?>

	<?php endif; ?>
<?php else:
	newspack_categories();
	?>
<?php endif; ?>