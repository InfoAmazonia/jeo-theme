<?php
require __DIR__ . '/inc/generic-css-injection.php';
require __DIR__ . '/inc/template-tags.php';

/**
 * Custom typography styles for child theme.
 */

require get_stylesheet_directory() . '/inc/child-typography.php';

/**
 * Customizer functions.
 */
require get_stylesheet_directory() . '/inc/child-customizer.php';

/**
 * Newspack Scott functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Newspack Scott
 */

function childtheme_add_post_formats()
{
	add_theme_support('post-formats', array('gallery', 'video', 'image', 'link', 'audio'));
}

add_action('after_setup_theme', 'childtheme_add_post_formats', 11);

if (!function_exists('newspack_scott_setup')) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function newspack_scott_setup()
	{
		// Remove the default editor styles
		remove_editor_styles();
		// Add child theme editor styles, compiled from `style-child-theme-editor.scss`.
		add_editor_style('styles/style-editor.css');
	}
endif;
add_action('after_setup_theme', 'newspack_scott_setup', 12);

/**
 * Function to load style pack's Google Fonts.
 */
function newspack_scott_fonts_url()
{
	$fonts_url = '';

	/**
	 * Translators: If there are characters in your language that are not
	 * supported by Roboto , translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$roboto = esc_html_x('on', 'Roboto font: on or off', 'newspack-scott');
	if ('off' !== $roboto) {
		$font_families   = array();
		$font_families[] = 'Roboto:400,400i,600,600i';

		$query_args = array(
			'family'  => urlencode(implode('|', $font_families)),
			'subset'  => urlencode('latin,latin-ext'),
			'display' => urlencode('swap'),
		);

		$fonts_url = add_query_arg($query_args, 'https://fonts.googleapis.com/css');
	}
	return esc_url_raw($fonts_url);
}

/**
 * Display custom color CSS in customizer and on frontend.
 */
function newspack_scott_custom_colors_css_wrap()
{
	// Only bother if we haven't customized the color.
	if ((!is_customize_preview() && 'default' === get_theme_mod('theme_colors', 'default')) || is_admin()) {
		return;
	}
	require_once get_stylesheet_directory() . '/inc/child-color-patterns.php';
?>

	<style type="text/css" id="custom-theme-colors-scott">
		<?php echo newspack_scott_custom_colors_css(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
		?>
	</style>
<?php
}
add_action('wp_head', 'newspack_scott_custom_colors_css_wrap');

/**
 * Display custom font CSS in customizer and on frontend.
 */
function newspack_scott_typography_css_wrap()
{
	if (is_admin() || (!get_theme_mod('font_body', '') && !get_theme_mod('font_header', '') && !get_theme_mod('accent_allcaps', true))) {
		return;
	}
?>

	<style type="text/css" id="custom-theme-fonts-scott">
		<?php echo newspack_scott_custom_typography_css(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
		?>
	</style>

<?php
}
add_action('wp_head', 'newspack_scott_typography_css_wrap');


/**
 * Enqueue scripts and styles.
 */
function newspack_scott_scripts()
{
	// Enqueue Google fonts.
	wp_enqueue_style('newspack-scott-fonts', newspack_scott_fonts_url(), array('jeo-theme-bootstrap'), null);
	wp_enqueue_style('jeo-theme-fontawesome', "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css", array(), '5.12.0', 'all');
	wp_enqueue_style('jeo-theme-bootstrap', "https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css", array(), '4.5', 'all');
	wp_enqueue_style('app', get_stylesheet_directory_uri() . '/dist/app.css', ['newspack-style'], filemtime(get_stylesheet_directory() . '/dist/app.css'), 'all');
	wp_enqueue_script('main-app', get_stylesheet_directory_uri() . '/dist/app.js', ['jquery']);
	//wp_enqueue_script( 'jeo-theme-scripts', get_stylesheet_directory_uri()."/js/main.js", array(), "0.1.0");
}
add_action('wp_enqueue_scripts', 'newspack_scott_scripts');


/**
 * Enqueue supplemental block editor styles.
 */
function newspack_scott_editor_customizer_styles()
{
	// Enqueue Google fonts.
	wp_enqueue_style('newspack-scott-fonts', newspack_scott_fonts_url(), array(), null);

	// Check for color or font customizations.
	$theme_customizations = '';
	require_once get_stylesheet_directory() . '/inc/child-color-patterns.php';

	if ('custom' === get_theme_mod('theme_colors')) {
		// Include color patterns.
		$theme_customizations .= newspack_scott_custom_colors_css();
	}

	if (get_theme_mod('font_body', '') || get_theme_mod('font_header', '') || get_theme_mod('accent_allcaps', true)) {
		$theme_customizations .= newspack_scott_custom_typography_css();
	}

	// If there are any, add those styles inline.
	if ($theme_customizations) {
		// Enqueue a non-existant file to hook our inline styles to:
		wp_register_style('newspack-scott-editor-inline-styles', false);
		wp_enqueue_style('newspack-scott-editor-inline-styles');
		// Add inline styles:
		wp_add_inline_style('newspack-scott-editor-inline-styles', $theme_customizations);
	}
}
add_action('enqueue_block_editor_assets', 'newspack_scott_editor_customizer_styles');




/**
 * Add custom taxonomies
 *
 * Additional custom taxonomies can be defined here
 * http://codex.wordpress.org/Function_Reference/register_taxonomy
 */
function add_custom_taxonomies()
{
	// Add new "region" taxonomy to Posts
	register_taxonomy('region', 'post', array(
		'hierarchical' => false,
		'public' => true,
		'show_ui' => true,
		'show_admin_column' => true,
		'show_in_rest' => true,
		'show_tagcloud' => false,
		'labels' => array(
			'name' => __('Regions', 'jeo'),
			'singular_name' => __('Region', 'jeon'),
			'search_items' =>  __('Search Regions'),
			'all_items' => __('All Regions'),
			//'parent_item' => __('Parent Location'),
			//'parent_item_colon' => __('Parent Location:'),
			'edit_item' => __('Edit Region'),
			'update_item' => __('Update Region'),
			'add_new_item' => __('Add New Region'),
			'new_item_name' => __('New Region Name'),
			'menu_name' => __('Regions'),
		),
		'rewrite' => array(
			'slug' => 'region',
			'with_front' => false,
			'hierarchical' => true
		),
	));


	// Add new "Locations" taxonomy to Posts
	register_taxonomy('topic', 'post', array(
		'hierarchical' => false,
		'public' => true,
		'show_ui' => true,
		'show_admin_column' => true,
		'show_in_rest' => true,
		'show_tagcloud' => false,
		'labels' => array(
			'name' => __('Topics', 'jeo'),
			'singular_name' => __('Topic', 'jeon'),
			'search_items' =>  __('Search topics'),
			'all_items' => __('All topics'),
			//'parent_item' => __('Parent Location'),
			//'parent_item_colon' => __('Parent Location:'),
			'edit_item' => __('Edit topic'),
			'update_item' => __('Update topic'),
			'add_new_item' => __('Add New Topics'),
			'new_item_name' => __('New Topic Name'),
			'menu_name' => __('Topics'),
		),
		'rewrite' => array(
			'slug' => 'topic',
			'with_front' => false,
			'hierarchical' => true
		),
	));
}
add_action('init', 'add_custom_taxonomies', 0);

function register_metaboxes()
{
	add_meta_box(
		'display-autor-info',
		__('Show author bio', 'jeo'),
		'display_autor_bio_callback',
		'post'
	);
}

function display_autor_bio_callback()
{
	wp_nonce_field(basename(__FILE__), 'prfx_nonce');
	$prfx_stored_meta = get_post_meta(get_the_ID());
?>

	<p>
		<span class="prfx-row-title"><?php _e('Check to enable the author info: ', 'jeo') ?></span>
		<div class="prfx-row-content">
			<label for="author-bio-display">
				<input type="checkbox" name="author-bio-display" id="author-bio-display" value="false" <?php if (isset($prfx_stored_meta['author-bio-display'])) checked($prfx_stored_meta['author-bio-display'][0], true); ?> />
				<?php _e('Author bio', 'prfx-textdomain') ?>
			</label>

		</div>
	</p>

<?php
}

/**
 * Saves the custom meta input
 */
function author_bio_display_meta_save($post_id)
{

	// Checks save status - overcome autosave, etc.
	$is_autosave = wp_is_post_autosave($post_id);
	$is_revision = wp_is_post_revision($post_id);
	$is_valid_nonce = (isset($_POST['prfx_nonce']) && wp_verify_nonce($_POST['prfx_nonce'], basename(__FILE__))) ? 'true' : 'false';

	// Exits script depending on save status
	if ($is_autosave || $is_revision || !$is_valid_nonce) {
		return;
	}

	// Checks for input and saves - save checked as yes and unchecked at no
	if (isset($_POST['author-bio-display'])) {
		update_post_meta($post_id, 'author-bio-display', true);
	} else {
		update_post_meta($post_id, 'author-bio-display', false);
	}
}

add_action('save_post', 'author_bio_display_meta_save');
add_action('add_meta_boxes', 'register_metaboxes');
