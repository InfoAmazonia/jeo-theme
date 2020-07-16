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

?>