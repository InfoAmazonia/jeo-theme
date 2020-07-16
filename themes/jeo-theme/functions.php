<?php
require __DIR__ . '/inc/generic-css-injection.php';
require __DIR__ . '/inc/template-tags.php';
require __DIR__ . '/inc/api.php';
require __DIR__ . '/inc/newspack-functions-overwrites.php';
require __DIR__ . '/inc/widgets.php';
require __DIR__ . '/inc/metaboxes.php';
require __DIR__ . '/inc/gutenberg-blocks.php';


add_filter('post_link', 'custom_get_permalink', 10, 3);

function custom_get_permalink($url, $post, $leavename = false) {
	$external_source_link = get_post_meta($post->ID, 'external-source-link', true);
	if ($external_source_link) {
		return $external_source_link;
	}

	return $url;
}

/**
 * Enqueue scripts and styles.
 */
function newspack_scripts_third_typography() {
	if ( get_theme_mod( 'accent_font_import_code_alternate', '' ) ) {
		wp_enqueue_style( 'newspack-font-accent-import', newspack_custom_typography_link( 'accent_font_import_code_alternate' ), array(), null );
	}

}
add_action( 'wp_enqueue_scripts', 'newspack_scripts_third_typography' );

/**
 * Decides which logo to use, based on Customizer settings and current post.
 */
function newspack_the_sticky_logo() {
	// By default, don't use the alternative logo.
	$use_sticky_logo = false;
	// Check if an sticky logo has been set:
	$has_sticky_logo = ( '' !== get_theme_mod( 'logo_sticky_image', '' ) && 0 !== get_theme_mod( 'logo_sticky_image', '' ) );

	if ( $has_sticky_logo ) : ?>
		<a class="custom-logo-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
			<?php
			echo wp_get_attachment_image(
				get_theme_mod( 'logo_sticky_image', '' ),
				'logo-sticky-image',
				'',
				array( 'class' => 'custom-logo' )
			);
			?>
		</a>
	<?php
	endif;

	// Otherwise, return the regular logo:
	if ( !$has_sticky_logo && has_custom_logo() ) {
		the_custom_logo();
	}
}

function newspack_author_social_links( $author_id, $size = 24 ) {
	// Get list of available social profiles.
	$social_profiles = array(
		'facebook',
		'twitter',
		'instagram',
		'linkedin',
		'myspace',
		'pinterest',
		'soundcloud',
		'tumblr',
		'youtube',
		'wikipedia',
	);

	// Create empty string for links.
	$links = '';

	// Create array of allowed HTML, including SVG markup.
	$allowed_html = array(
		'a'  => array(
			'href'   => array(),
			'title'  => array(),
			'target' => array(),
		),
		'li' => array(),
	);
	$allowed_html = array_merge( $allowed_html, newspack_sanitize_svgs() );

	foreach ( $social_profiles as $profile ) {
		if ( '' !== get_the_author_meta( $profile, $author_id ) ) {
			if ( 'twitter' === $profile ) {
				$links .= '<li><a href="https://twitter.com/' . esc_attr( get_the_author_meta( $profile, $author_id ) ) . '" target="_blank">' . newspack_get_social_icon_svg( $profile, $size, $profile ) . '</a></li>';
			} else {
				$links .= '<li><a href="' . esc_url( get_the_author_meta( $profile, $author_id ) ) . '" target="_blank">' . newspack_get_social_icon_svg( $profile, $size, $profile ) . '</a></li>';
			}
		}
	}

	if ( '' !== $links && true === get_theme_mod( 'show_author_social', false ) ) {
		echo '<div><ul class="author-social-links">' . wp_kses( $links, $allowed_html ) . '</ul></div>';
	}
}

// Creates  widgets
class newsletter_widget extends WP_Widget {
 
	// The construct part  
	function __construct() {
		parent::__construct(
			'newsletter_widget', 
			__('Newsletter Widget', 'newsletter_widget_domain'), 
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
			__('Most Read Widget', 'most_read_widget_domain'), 
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
			__('Story Maps Widget', 'story_maps_widget_domain'), 
			array( 'description' => __( 'Story Maps Widget', 'story_maps_widget_domain' ), ) );
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