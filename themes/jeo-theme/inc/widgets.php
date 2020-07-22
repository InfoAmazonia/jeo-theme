<?php
/**
 * Register our sidebars, widgetized areas and widgets.
 *
 */
function widgets_areas() {

	register_sidebar( array(
		'name'          => 'Article below author info',
		'id'            => 'after_post_widget_area',
		'before_widget' => '<div class="widget-area-after-post">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => 'Category page sidebar',
		'id'            => 'category_page_sidebar',
		'before_widget' => '<div class="widget-category_page_sidebar">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="category_page_sidebar">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => 'Author page sidebar',
		'id'            => 'author_page_sidebar',
		'before_widget' => '<div class="widget-author_page_sidebar">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="author_page_sidebar">',
		'after_title'   => '</h2>',
	) );


}
add_action( 'widgets_init', 'widgets_areas' );


// Creates  widgets
class newsletter_widget extends WP_Widget {
 
	// The construct part  
	function __construct() {
		parent::__construct(
			'newsletter_widget', 
			__('Newsletter', 'newsletter_widget_domain'), 
			array( 'description' => __( 'Newsletter widget', 'newsletter_widget_domain' ), ) );
	}
	  
	public function widget( $args, $instance ) {
		?>
		<div class="category-page-sidebar">
			<div class="newsletter">
				<i class="fa fa-envelope fa-3x" aria-hidden="true"></i>
				<div class="newsletter-header">
					<p>SUBSCRIBE OUR<br>NEWSLETTER</p>
				</div>
				<p class="anchor-text">RECEIVE NEWS BY EMAIL</p>
				<form>
					<div>
						<input type="text" placeholder="your email"></input>
						<button type="submit"><i class="fa fa-arrow-right" aria-hidden="true"></i></button>
					</div>
				</form>
				<p class="link">Lorem ipsum sit amet dolo <a href="#">hyperlink</a></p>
				<p class="last-edition"><a href="#">SEE LAST EDITION</a></p>
			</div>
		</div>
		<?php 
	}
}

class most_read_widget extends WP_Widget {
 
	// The construct part  
	function __construct() {
		parent::__construct(
			'most_read_widget', 
			__('Most Read', 'most_read_widget_domain'), 
			array( 'description' => __( 'Most Read Widget', 'most_read_widget_domain' ), ) );
	}
	  
	public function widget( $args, $instance ) {
		?>
		<div class="category-most-read">
            <div class="header">
                <p>MOST READ</p>
            </div>
            <div class="posts">
                <p>Título do conteúdo que geralmente será um título grande</p>
                <p>Título do conteúdo que geralmente será um título grande</p>
                <p>Título do conteúdo que geralmente será um título grande</p>
            </div>
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
			array( 'description' => __( 'Story Maps', 'story_maps_widget_domain' ), ) );
	}
	  
	public function widget( $args, $instance ) {
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

function my_post_gallery_widget($output, $attr) {
    global $post;

    if (isset($attr['orderby'])) {
        $attr['orderby'] = sanitize_sql_orderby($attr['orderby']);
        if (!$attr['orderby'])
            unset($attr['orderby']);
    }

    extract(shortcode_atts(array(
        'order' => 'ASC',
        'orderby' => 'menu_order ID',
        'id' => $post->ID,
        'itemtag' => 'dl',
        'icontag' => 'dt',
        'captiontag' => 'dd',
        'columns' => 3,
        'size' => 'thumbnail',
        'include' => '',
        'exclude' => ''
    ), $attr));

    $id = intval($id);
    if ('RAND' == $order) $orderby = 'none';

    if (!empty($include)) {
        $include = preg_replace('/[^0-9,]+/', '', $include);
        $_attachments = get_posts(array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));

        $attachments = array();
        foreach ($_attachments as $key => $val) {
            $attachments[$val->ID] = $_attachments[$key];
        }
    }

    if (empty($attachments)) return '';

	$output .= "<div class=\"image-gallery\">";
	$output .= "<div class=\"image-gallery-header\"><p>IMAGE GALLERY</p></div>";
    $output .= "<div class=\"image-gallery-content\">";

    foreach ($attachments as $id => $attachment) {
        $img = wp_get_attachment_image_src($id, 'full');

        $output .= "<div class=\"image\">\n";
        $output .= "<img src=\"{$img[0]}\"/>\n";
        $output .= "</div>\n";
    }

	$output .= "</div>\n";
	$output .= "<button><a target=\"blank\" href=\"";
	$output .= $attr['see_more_url'];
	$output .= "\">SEE MORE</a></button>\n";

	$output .= "</div>\n";


    return $output;
}

function newsletter_load_widget() {
    register_widget( 'newsletter_widget' );
}

function most_read_load_widget() {
    register_widget( 'most_read_widget' );
}

function story_maps_load_widget() {
    register_widget( 'story_maps_widget' );
}

add_action( 'widgets_init', 'newsletter_load_widget' );
add_action( 'widgets_init', 'most_read_load_widget' );
add_action( 'widgets_init', 'story_maps_load_widget' );
add_filter('post_gallery', 'my_post_gallery_widget', 10, 2);


// IMAGE GALLERY FORM
function image_gallery_form( $widget, $return, $instance ) {
 
    if ( 'media_gallery' == $widget->id_base ) {
 
        $see_more_url = isset( $instance['see_more_url'] ) ? $instance['see_more_url'] : '';
        ?>
            <p>
                <label for="<?php echo $widget->get_field_id('see_more_url'); ?>">
                    <?php _e( 'See more URL (requires https://)', 'image_gallery' ); ?>
                </label>
                <input class="text" value="<?php echo $see_more_url ?>" type="text" id="<?php echo $widget->get_field_id('see_more_url'); ?>" name="<?php echo $widget->get_field_name('see_more_url'); ?>" />
            </p>
        <?php
    }
}

function image_gallery_save_form( $instance, $new_instance ) {
	
	$instance['see_more_url'] = $new_instance['see_more_url'];
	return $instance;
}

add_filter('in_widget_form', 'image_gallery_form', 10, 3 );
add_filter( 'widget_update_callback', 'image_gallery_save_form', 10, 2 );

?>