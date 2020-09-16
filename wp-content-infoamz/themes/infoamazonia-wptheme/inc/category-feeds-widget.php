<?php
 // by mohjak
class Actual_Widget extends WP_Widget {
     // WordPress WP_Widget Class
     public function __construct($id_base, $name, $widget_options = array(), $control_options = array()) {
 
         parent::__construct(
 			// extend WP_Widget as per codex
 			$id_base, $name, $widget_options, $control_options
         );
     }
}
 class CategoryFeedsWidget extends Actual_Widget {
 
 	public function __construct($id_base, $name, $widget_options = array(), $control_options = array()) {
 		// by mohjak
 		$this->id_base = $id_base;
 		$this->name = $name;
 		$this->widget_options = $widget_options;
 		$this->control_options = $control_options;
 
 		parent::__construct($this->id_base, $this->name, $this->widget_options, $this->control_options);
    }
}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => __('RSS Feeds', 'infoamazonia'), 'categories' => '' ) );
		$title = $instance['title'];
		$categories = $instance['categories'];
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'infoamazonia'); ?>: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('categories'); ?>"><?php _e('Categories separated by comma', 'infoamazonia'); ?>: <input class="widefat" id="<?php echo $this->get_field_id('categories'); ?>" name="<?php echo $this->get_field_name('categories'); ?>" type="text" value="<?php echo attribute_escape($categories); ?>" /></label></p>
		<?php
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['categories'] = $new_instance['categories'];
		return $instance;
	}

	function widget($args, $instance) {
		extract($args, EXTR_SKIP);

		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', __($instance['title']));
		$categories = $instance['categories'];

		echo $before_widget;

		echo $before_title . $title . $after_title;

		echo '<ul class="categories">';
			if(!$categories) {
				$category_ids = get_all_category_ids();
			} else {
				$category_ids = explode(',', $categories);
			}
			foreach($category_ids as $cat_id) {
				echo '<li><a href="' . get_category_feed_link($cat_id) . '" title="' . __('RSS Feed', 'infoamazonia') . '" target="_blank">' . get_cat_name($cat_id) . '</a></li>';
			}
		echo '</ul>';

		echo $after_widget;
	}
// by mohjak
 function register_widget_category_feeds_widget() {
 	$widget_ops = array('classname' => 'widget_category_feeds', 'description' => __('RSS Feeds by selected categories', 'infoamazonia') );
 
 	$id_base = 'CategoryFeedsWidget';
 	$name = __('Category Feed Links', 'infoamazonia');
 	$widget_options = $widget_ops;
 	$control_options = array();
 
 	$widget = new CategoryFeedsWidget($id_base, $name, $widget_options, $control_options);
 	return register_widget($widget);
 }
 add_action( 'widgets_init', 'register_widget_category_feeds_widget' );
?>
