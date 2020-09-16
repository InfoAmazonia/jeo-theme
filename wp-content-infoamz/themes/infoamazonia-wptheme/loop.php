<?php
// by mohjkak 2020-07-29 issue#6: cache issue https://tech.openinfo.cc/earth/infoamazonia/-/issues/6#note_8539
wp_cache_flush();
?>
<ul class="list-posts row">
	<?php while(have_posts()) : the_post(); ?>
		<li id="post-<?php the_ID(); ?>" <?php post_class('post-item four columns'); ?>>
			<article>
				<header class="post-header">
					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
						<?php
						if(has_post_thumbnail())
							the_post_thumbnail('post-thumb');
						else
							echo '<img src="' . get_post_meta($post->ID, 'picture', true) . '" />';
						?>
					</a>
					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<p class="meta clearfix">
						<span class="date">
							<span class="lsf">&#xE15e;</span>
							<span class="date-content"><?php echo get_the_date(_x('m/d/Y', 'reduced date format', 'infoamazonia')); ?></span>
						</span>
						<?php
						if(get_the_terms($post->ID, 'publisher')) :
							?>
							<span class="publisher">
								<span class="lsf">clip</span>
								<span class="publisher-content">
									<?php
                                    $terms_arr = get_the_terms($post->ID, 'publisher');
                                    $first_term = array_shift($terms_arr);
									echo $first_term->name;
									?>
								</span>
							</span>
							<?php
						endif;
						?>
					</p>
				</header>
				<section class="post-content">
					<?php the_excerpt(); ?>
				</section>
				<footer class="post-actions">
					<div class="buttons">
						<a class="button" href="<?php the_permalink(); ?>"><?php _e('Read more', 'infoamazonia'); ?></a>
						<a class="button" href="<?php echo jeo_get_share_url(array('p' => $post->ID)); ?>"><?php _e('Share', 'infoamazonia'); ?></a>
					</div>
				</footer>
			</article>
		</li>
	<?php endwhile; ?>
</ul>
<div class="twelve columns">
	<?php if(function_exists('wp_paginate')) wp_paginate(); ?>
</div>
<script type="text/javascript">
	(function($) {
		$(document).ready(function() {
			$('.list-posts').imagesLoaded(function() {

				var $media = $('.list-posts .media-limit img');

				$media.each(function() {

					var containerHeight = $(this).parents('.media-limit').height();
					var imageHeight = $(this).height();

					var topOffset = (containerHeight - imageHeight) / 2;

					if(topOffset < 0) {
						$(this).css({
							'margin-top': topOffset
						});
					}

				});

			});

		});

		jeo.mapReady(function(map) {
			$('.list-posts li').click(function() {
				var markerID = $(this).attr('id');
				$('html,body').animate({
					scrollTop: $('#stage').offset().top
				}, 400);
				map.markers.openMarker(markerID, false);

				// by mohjak 2020-07-28 issue#6 Read more issue https://tech.openinfo.cc/earth/infoamazonia/-/issues/6
				var postUrl = $(this).find('.post-header').find('a:first').attr('href');
				$('.map-sidebar').find('.button.read-button').attr('href', postUrl);

				// by mohjak 2020-07-30 isue#2 load 4 stories in sidebar https://tech.openinfo.cc/earth/openearth/-/issues/147
				map.$.sidebar.addClass('active');

				return false;
			});

			$('.list-posts li .button').click(function() {
				window.location = $(this).attr('href');
			});

			jeo.markerClicked(function(e) {
				// by mohjak 2020-07-29 issue#6 marker clicked change read more link https://tech.openinfo.cc/earth/infoamazonia/-/issues/6#note_8540
				// by mohjak 2020-07-29 issue#11 marker clicked change read more link https://tech.openinfo.cc/earth/infoamazonia/-/issues/11#note_8541
				var postUrl = e.target.feature.properties.permalink;
				$('.map-sidebar').find('.button.read-button').attr('href', postUrl);

				// by mohjak 2020-07-30 isue#2 load 4 stories in sidebar https://tech.openinfo.cc/earth/openearth/-/issues/147
				map.$.sidebar.addClass('active');

				return false;
			});

		});

	})(jQuery);
</script>
