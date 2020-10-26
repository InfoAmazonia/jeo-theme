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
		<!-- publishers -->
		<?php 
			$partners = get_the_terms( get_the_id(), 'partner');
			if ($partners && count($partners) > 0){
				$partner_link = get_post_meta($post->ID, 'partner-link', true); 
				if (class_exists('WPSEO_Primary_Term')) {
					$wpseo_primary_term = new WPSEO_Primary_Term( 'partner', get_the_id() );
					$wpseo_primary_term = $wpseo_primary_term->get_primary_term();
					$term = get_term( $wpseo_primary_term );
	
					if ($term || count($partners) == 1 ) {

						$partner_name = '';
						if($term) {
							$partner_name = $term->name;
						} else if (count($partners) == 1) {
							$partner_name = $partners[0]->name;
						}

						?>
						<div class="publishers">
										<span class="publisher-name">
											<?php echo esc_html__('By', 'newspack'); ?>
											<a href="<?= $partner_link ?>" >
												<i class="fas fa-sync-alt publisher-icon"></i>
												<?php echo $partner_name; ?>
											</a>
										</span>
								</div>
								<?php 
	
					} 
				}
			}?>
			<!-- publishers -->
				
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