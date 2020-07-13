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
