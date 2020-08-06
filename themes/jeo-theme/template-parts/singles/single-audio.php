<section id="primary" class="content-area <?php echo esc_attr(newspack_get_category_tag_classes(get_the_ID())) . ' ' . newspack_featured_image_position(); ?>">
    <main id=" main" class="site-main">
        <header>
            <div class="entry-header">
                <?php get_template_part('template-parts/header/entry', 'header'); ?>
            </div>
        </header>

        <div class="main-content">
            <div class="entry-subhead">
                <?php
                // Display Jetpack Share icons, if enabled
                if (function_exists('sharing_display')) {
                    sharing_display('', true);
                }
                ?>
            </div>

            <?php
            if (is_active_sidebar('article-1')) {
                dynamic_sidebar('article-1');
            }

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
		$posts = guaraci\related_posts::get_posts(get_the_id(), 3)->posts;
		$posts_ids = [];
		foreach($posts as $key=>$value) {
			array_push($posts_ids, $value->ID);
		}

		
		$posts_query_args['post__in'] = $posts_ids;

		

		$related_posts = new \WP_Query($posts_query_args); 
    ?>
    <?php if(sizeof($related_posts->posts) >= 3): ?>
					<div class="related-posts">
						<p class="title-section"><?= __('Related Posts') ?></p>

						<div class="posts">
							<?php foreach($related_posts->posts as $key=>$value): ?>
								<div class="post">
										<div class="thumbnail">
											<a class="thumbnail-inner" href="<?php echo get_permalink($value->ID) ?>" target="blank">
												<?php echo get_the_post_thumbnail($value->ID) ?>
											</a>
										</div>
										<div class="entry-container"> 
											<p class="title">
												<a href="<?php echo get_permalink($value->ID) ?>" target="blank">
													<?php echo $value->post_title ?>
												</a>
											</p>
											<p class="date"><?php  echo get_the_time('F j, Y', $value->ID); ?></p>
											<p class="excerpt"><?php echo get_the_excerpt($value->ID) ?></p>
										</div>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
    <?php endif ?>
</section><!-- #primary -->