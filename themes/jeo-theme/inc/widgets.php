<?php

/**
 * Register our sidebars, widgetized areas and widgets.
 *
 */
function widgets_areas() {

	register_sidebar(array(
		'name'          => 'Article below author info',
		'id'            => 'after_post_widget_area',
		'before_widget' => '<div class="widget-area-after-post">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	));

	register_sidebar(array(
		'name'          => 'Category page sidebar',
		'id'            => 'category_page_sidebar',
		'before_widget' => '<div class="widget-category_page_sidebar">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="category_page_sidebar">',
		'after_title'   => '</h2>',
	));

	register_sidebar(array(
		'name'          => 'Author page sidebar',
		'id'            => 'author_page_sidebar',
		'before_widget' => '<div class="widget-author_page_sidebar">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="author_page_sidebar">',
		'after_title'   => '</h2>',
	));
}
add_action('widgets_init', 'widgets_areas');


// Creates  widgets
class newsletter_widget extends WP_Widget {

	// The construct part  
	function __construct() {
		parent::__construct(
			'newsletter_widget',
			__('Newsletter', 'newsletter_widget_domain'),
			array('description' => __('Newsletter widget', 'newsletter_widget_domain'),)
		);
	}

	public function widget($args, $instance) {
?>
	<? if ($instance) : ?>
		<div class="category-page-sidebar">
			<div class="newsletter <?= $instance['model_type'] ?>">
				<?= ($instance['model_type'] == 'horizontal') ? '<div>' : '' ?>
				<i class="fa fa-envelope fa-3x" aria-hidden="true"></i>
				<div class="newsletter-header">
					<p><?= $instance['title'] ?> </p>
				</div>
				<p class="anchor-text">
					<?= $instance['subtitle'] ?>
					<?php if (!empty($instance['last_edition_link']) && $instance['model_type'] == 'horizontal') : ?>
						<?= empty($instance['last_edition_link']) ? '' :  '<a href="' . $instance['last_edition_link'] . '">SEE LAST EDITION</a>' ?>
					<?php endif; ?>
				</p>
				<?= ($instance['model_type'] == 'horizontal') ? '</div>' : '' ?>
				<?= ($instance['model_type'] == 'horizontal') ? '<div>' : '' ?>
				<?php if (!empty($instance['newsletter_shortcode'])) : ?>
					<?= do_shortcode($instance['newsletter_shortcode']) ?>
				<?php endif; ?>
				<?php if (!empty($instance['adicional_content'])) : ?>
					<p class="link"><?= $instance['adicional_content'] ?></p>
				<?php endif; ?>
				<?php if (!empty($instance['last_edition_link']) && $instance['model_type'] == 'vertical') : ?>
					<p class="last-edition"><?= empty($instance['last_edition_link']) ? '' :  '<a href="' . $instance['last_edition_link'] . '">SEE LAST EDITION</a>' ?></p>
				<?php endif; ?>
				<?= ($instance['model_type'] == 'horizontal') ? '</div>' : '' ?>
			</div>
		</div>
	<?php endif; ?>
	<?php
	}

	public function form($instance) {
		$title = !empty($instance['title']) ? $instance['title'] : esc_html__('', 'jeo');
		$subtitle = !empty($instance['subtitle']) ? $instance['subtitle'] : esc_html__('', 'jeo');
		$newsletter_shortcode = !empty($instance['newsletter_shortcode']) ? $instance['newsletter_shortcode'] : esc_html__('', 'jeo');
		$last_edition_link = !empty($instance['last_edition_link']) ? $instance['last_edition_link'] : esc_html__('', 'jeo');
		$adicional_content = !empty($instance['adicional_content']) ? $instance['adicional_content'] : esc_html__('', 'jeo');
		$model_type = !empty($instance['model_type']) ? $instance['model_type'] : esc_html__('vertical', 'jeo');
		$custom_style = !empty($instance['custom_style']) ? $instance['custom_style'] : esc_html__('', 'jeo');
	?>
		<p>
			You are allowed to add <strong>HTML</strong> in any of those fields
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('model_type')); ?>"><?php esc_attr_e('Model type:', 'jeo'); ?></label>
			<select class="widefat" id="<?php echo esc_attr($this->get_field_id('model_type')); ?>" name="<?php echo esc_attr($this->get_field_name('model_type')); ?>">
				<option value="horizontal" <?= $model_type == 'horizontal' ? 'selected' : '' ?>>Horizontal</option>
				<option value="vertical" <?= $model_type == 'vertical' ? 'selected' : '' ?>>Vertical</option>
			</select>
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_attr_e('Title:', 'jeo'); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('subtitle')); ?>"><?php esc_attr_e('Subtitle:', 'jeo'); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('subtitle')); ?>" name="<?php echo esc_attr($this->get_field_name('subtitle')); ?>" type="text" value="<?php echo esc_attr($subtitle); ?>">
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('newsletter_shortcode')); ?>"><?php esc_attr_e('Newsletter form shortcode:', 'jeo'); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('newsletter_shortcode')); ?>" name="<?php echo esc_attr($this->get_field_name('newsletter_shortcode')); ?>" type="text" value="<?php echo esc_attr($newsletter_shortcode); ?>">
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('last_edition_link')); ?>"><?php esc_attr_e('Last edition link:', 'jeo'); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('last_edition_link')); ?>" name="<?php echo esc_attr($this->get_field_name('last_edition_link')); ?>" type="text" value="<?php echo esc_attr($last_edition_link); ?>">
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('adicional_content')); ?>"><?php esc_attr_e('Adicional Content:', 'jeo'); ?></label>
			<textarea class="widefat" id="<?php echo esc_attr($this->get_field_id('adicional_content')); ?>" name="<?php echo esc_attr($this->get_field_name('adicional_content')); ?>"><?php echo $adicional_content; ?></textarea>
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('custom_style')); ?>"><?php esc_attr_e('Container style:', 'jeo'); ?></label>
			<textarea class="widefat" id="<?php echo esc_attr($this->get_field_id('custom_style')); ?>" name="<?php echo esc_attr($this->get_field_name('custom_style')); ?>"><?php echo $custom_style; ?></textarea>
		</p>


	<?php
	}
}

class most_read_widget extends WP_Widget {

	// The construct part  
	function __construct() {
		parent::__construct(
			'most_read_widget',
			__('Most Read', 'most_read_widget_domain'),
			array('description' => __('Most Read Widget', 'most_read_widget_domain'),)
		);
	}

	public function widget($args, $instance) {
		$category = '';
		$author = '';
		$most_read = [];
		$ids = [];
		$posts_ids = [];
		$posts_query_args = [];

		if(is_category()) {
			$category = get_the_category()[0];
			$most_read = \PageViews::get_top_viewed(-1, ['post_type' => 'post', 'from' => '01-01-2001']);
			$posts_query_args['category__in'] = [$category->cat_ID];
		} else if(is_author()) {
			$author = get_the_author_meta('ID');
			$most_read = \PageViews::get_top_viewed(-1, ['post_type' => 'post', 'from' => '01-01-2001']);
			$posts_query_args['author__in'] = [$author];

		}

		$ids = array();
		foreach ($most_read as $post => $value) {
			array_push($ids, $value->post_id);
		}

		$posts_query_args['post__in'] = $ids;
		$posts_query_args['orderby'] = 'post__in';
		$most_read_query = new \WP_Query($posts_query_args); 

		foreach ($most_read_query->posts as $post => $value) {
			array_push($posts_ids, $value->ID);
		}

		?>
			<div class="category-most-read">
				<div class="header">
					<p>MOST READ</p>
				</div>
				<?php if(sizeof($posts_ids) >= 1): ?>
					<div class="posts">
						<?php foreach(array_slice($posts_ids, 0, 3) as $key=>$value){ 
							$title = get_the_title($value);
							$author_id = get_post_field( 'post_author', $value );
							$author = get_the_author_meta('display_name', $author_id);
							$url = get_permalink($value);
						?>
							<div class="post">
								<a class="post-link" href="<?php echo $url; ?>">
									<div class="post-thumbnail"><?php echo get_the_post_thumbnail($value); ?></div>
									<p class="post-title"><?php echo $title; ?></p>
									<p class="post-author">by <strong><?php echo $author; ?></strong></p>
								</a>
							</div>
						<?php } ?>
					</div>
				<?php else: ?>
					<p class="no-views-warming">The posts have no views yet.</p>
				<?php endif ?>

			</div>
	<?php
	}
}

class story_maps_widget extends WP_Widget {

	// The construct part  
	function __construct() {
		parent::__construct(
			'story_maps_widget',
			__('Story Maps', 'story_maps_widget_domain'),
			array('description' => __('Story Maps', 'story_maps_widget_domain'),)
		);
	}

	public function widget($args, $instance) {
	?>
		<div class="category-story-maps">
			<div class="header">
				<p>STORY MAPS</p>
			</div>
			<div class="maps">
				<p>Título do conteúdo que geralmente será um título grande</p>
				<p>Título do conteúdo que geralmente será um título grande</p>
				<p>Título do conteúdo que geralmente será um título grande</p>
			</div>
		</div>
<?php
	}
}

function newsletter_load_widget() {
	register_widget('newsletter_widget');
}

function most_read_load_widget() {
	register_widget('most_read_widget');
}

function story_maps_load_widget() {
	register_widget('story_maps_widget');
}

add_action('widgets_init', 'newsletter_load_widget');
add_action('widgets_init', 'most_read_load_widget');
add_action('widgets_init', 'story_maps_load_widget');

?>