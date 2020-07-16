<?php
/**
 * Register our sidebars and widgetized areas.
 *
 */
function widgets_init() {

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
add_action( 'widgets_init', 'widgets_init' );

?>