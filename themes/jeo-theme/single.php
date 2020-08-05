<?php

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Newspack
 */

get_header('single');
the_post();

$parent_type_category = get_category_by_slug('type')->cat_ID;
$post_categories = get_the_category();
$post_child_category = null;
foreach ($post_categories as $post_cat) {
	if ($parent_type_category == $post_cat->parent) {
		$post_child_category = $post_cat;
		break;
	}
}
if(isset($post_child_category->slug) && in_array ( $post_child_category->slug, ['opinion', 'audio', 'video'])):
	if ($post_child_category->slug === 'opinion') : ?>
		<?php get_template_part('template-parts/singles/single', 'opinion');
	elseif ($post_child_category->slug === 'audio') : ?>
		<?php get_template_part('template-parts/singles/single', 'audio'); 
	elseif ($post_child_category->slug === 'video') : ?>
		<?php get_template_part('template-parts/singles/single', 'video'); ?>
	<?php endif; ?>
<?php else : ?>
	<section id="primary" class="content-area <?php echo esc_attr(newspack_get_category_tag_classes(get_the_ID())) . ' ' . newspack_featured_image_position(); ?>">

		<main id="main" class="site-main">
			<?php
			$isImageBehind = false;

			if (in_array(newspack_featured_image_position(), array('behind'))) {
				$isImageBehind = true;
			}

			// Template part for large featured images.
			if (in_array(newspack_featured_image_position(), array('large', 'behind', 'beside'))) :
				get_template_part('template-parts/post/large-featured-image');
			else :
			?>
				<header class="entry-header">
					<?php get_template_part('template-parts/header/entry', 'header'); ?>
				</header>

			<?php endif; ?>

			<div class="main-content">
				<?php if ($isImageBehind) : ?>
					<div class="entry-subhead">
						<div class="entry-meta">
							<?php if (get_post_meta(get_the_ID(), 'author-bio-display', true)) : ?>
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
				<?php endif; ?>


				<?php
				if (is_active_sidebar('article-1')) {
					dynamic_sidebar('article-1');
				}

				// Place smaller featured images inside of 'content' area.
				if ('small' === newspack_featured_image_position()) :
					newspack_post_thumbnail();
				endif;

				get_template_part('template-parts/content/content', 'single');
				?>



			</div><!-- .main-content -->



		</main><!-- #main -->

		<div class="after-post-content-widget-area">
			<?php dynamic_sidebar('after_post_widget_area'); ?>
		</div>

		<div class="main-content">
			<?php
			// If comments are open or we have at least one comment, load up the comment template.
			if (comments_open() || get_comments_number()) {
				newspack_comments_template();
			}

			?>
		</div>
		<?php
		function add_months($months, DateTime $dateObject) {
			$next = new DateTime($dateObject->format('Y-m-d'));
			$next->modify('last day of +'.$months.' month');
	
			if($dateObject->format('d') > $next->format('d')) {
				return $dateObject->diff($next);
			} else {
				return new DateInterval('P'.$months.'M');
			}
		}
		function remove_months($months, DateTime $dateObject) {
			$next = new DateTime($dateObject->format('Y-m-d'));
			$next->modify('last day of -'.$months.' month');
	
			if($dateObject->format('d') > $next->format('d')) {
				return $dateObject->diff($next);
			} else {
				return new DateInterval('P'.$months.'M');
			}
		}
	
		function addEndCycle($d1, $months){
			$date = new DateTime($d1);
	
			$newDate = $date->add(add_months($months, $date));
	
			$newDate->sub(new DateInterval('P1D')); 
	
			$dateReturned = $newDate->format('Y-m-d'); 
	
			return $dateReturned;
		}
		function removeEndCycle($d1, $months){
			$date = new DateTime($d1);
	
			$newDate = $date->sub(remove_months($months, $date));
	
			$newDate->sub(new DateInterval('P1D')); 
	
			$dateReturned = $newDate->format('Y-m-d'); 
	
			return $dateReturned;
		}
			$current_date =get_the_time('Y-m-d', get_the_id());

			$months_before = guaraci\related_posts::get_months_before();
			$months_after = guaraci\related_posts::get_months_after();


			$date_after = removeEndCycle($current_date, $months_before);
			$date_before = addEndCycle($current_date, $months_after);

			$posts = guaraci\related_posts::get_posts(get_the_id(), 3, $date_after, $date_before)->posts;
			$posts_ids = [];
			foreach($posts as $key=>$value) {
				array_push($posts_ids, $value->ID);
			}

			
			$posts_query_args['post__in'] = $posts_ids;

			

			$related_posts = new \WP_Query($posts_query_args); 
		?>
		<div class="related-posts">
			<p class="title">RELATED POSTS</p>
			<div class="posts">
				<?php foreach($related_posts->posts as $key=>$value): ?>
					<div class="post">
						<a href="<?php echo get_permalink($value->ID) ?>" target="blank">
							<div class="thumbnail"><?php echo get_the_post_thumbnail($value->ID) ?></div>
							<p class="title"><?php echo $value->post_title ?></p>
							<p class="date"><?php  echo get_the_time('F j, Y', $value->ID); ?></p>
							<p class="excerpt"><?php echo get_the_excerpt($value->ID) ?></p>
						</a>	
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section><!-- #primary -->
<?php endif; ?>



<?php
get_footer();
