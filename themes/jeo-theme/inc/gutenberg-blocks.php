<?php
/**
 * Image box
 */
function custom_image_block() {

	// automatically load dependencies and version
	$asset_file = include(get_stylesheet_directory() . '/dist/imageBlock.asset.php');

	wp_register_script(
		'custom-image-block-editor',
		get_stylesheet_directory_uri() . '/dist/imageBlock.js',
		$asset_file['dependencies'],
		$asset_file['version']
		//filemtime(get_stylesheet_directory() . '/dist/imageBlock.js')
	);

	wp_register_style(
		'custom-image-block-editor',
		get_stylesheet_directory_uri() . '/assets/javascript/blocks/imageBlock/imageBlock.css',
		[],
		filemtime(get_stylesheet_directory() . '/assets/javascript/blocks/imageBlock/imageBlock.css'),
	);

	// wp_register_style(
	// 	'custom-image-block-block',
	// 	get_stylesheet_directory_uri() . '/assets/javascript/blocks/imageBlock/style.css',
	// 	array(),
	// 	filemtime(get_stylesheet_directory() . '/assets/javascript/blocks/imageBlock/style.css'),
	// 	'all',
	// );

	register_block_type('jeo-theme/custom-image-block-editor', array(
		'editor_script' => 'custom-image-block-editor',
		'editor_style'  => 'custom-image-block-editor',
		// 'style'         => 'custom-image-block-block',
	));
}

add_action('init', 'custom_image_block');


function custom_pullquote_scripts() {
	wp_enqueue_script(
		'be-editor',
		get_stylesheet_directory_uri() . '/assets/javascript/blocks/pullquoteBlock/index.js',
		array('wp-blocks', 'wp-dom'),
		filemtime(get_stylesheet_directory() . '/assets/javascript/blocks/pullquoteBlock/index.js'),
		true
	);

	wp_enqueue_style(
		'custom-pullquote-block',
		get_stylesheet_directory_uri() . '/assets/javascript/blocks/pullquoteBlock/style.css',
		array(),
		filemtime(get_stylesheet_directory() . '/assets/javascript/blocks/pullquoteBlock/style.css'),
		'all',
	);
}
add_action('enqueue_block_editor_assets', 'custom_pullquote_scripts');


function custom_group_block_scripts() {
	wp_enqueue_script(
		'be-editor-group',
		get_stylesheet_directory_uri() . '/assets/javascript/blocks/groupBlock/index.js',
		array('wp-blocks', 'wp-dom'),
		filemtime(get_stylesheet_directory() . '/assets/javascript/blocks/groupBlock/index.js'),
		true
	);

	wp_enqueue_style(
		'custom-group-block',
		get_stylesheet_directory_uri() . '/assets/javascript/blocks/groupBlock/style.css',
		array(),
		filemtime(get_stylesheet_directory() . '/assets/javascript/blocks/groupBlock/style.css'),
		'all',
	);
}
add_action('enqueue_block_editor_assets', 'custom_group_block_scripts');

/**
 * Newsletter
 */
function custom_newsletter_block() {

	// automatically load dependencies and version
	$asset_file = include(get_stylesheet_directory() . '/dist/newsletter.asset.php');

	wp_register_script(
		'custom-newsletter-block',
		get_stylesheet_directory_uri() . '/dist/newsletter.js',
		$asset_file['dependencies'],
		$asset_file['version']
		//filemtime(get_stylesheet_directory() . '/dist/imageBlock.js')
	);

	wp_register_style(
		'custom-newsletter-block',
		get_stylesheet_directory_uri() . '/assets/javascript/blocks/newsletter/newsletter.css',
		[],
		filemtime(get_stylesheet_directory() . '/assets/javascript/blocks/newsletter/newsletter.css'),
		'all'
	);

	register_block_type('jeo-theme/custom-newsletter-block', array(
		'editor_script' => 'custom-newsletter-block',
		'editor_style'  => 'custom-newsletter-block',
		//'style'         => 'custom-newsletter-block',
	));
}

add_action('init', 'custom_newsletter_block');


/**
 * Video gallery
 */
function custom_video_gallery() {

	// automatically load dependencies and version
	$asset_file = include(get_stylesheet_directory() . '/dist/videoGallery.asset.php');

	wp_register_script(
		'custom-video-gallery',
		get_stylesheet_directory_uri() . '/dist/videoGallery.js',
		$asset_file['dependencies'],
		$asset_file['version']
		//filemtime(get_stylesheet_directory() . '/dist/imageBlock.js')
	);

	wp_register_style(
		'custom-video-gallery',
		get_stylesheet_directory_uri() . '/assets/javascript/blocks/videoGallery/style.css',
		[],
		filemtime(get_stylesheet_directory() . '/assets/javascript/blocks/videoGallery/style.css'),
		'all'
	);

	register_block_type('jeo-theme/custom-video-gallery', array(
		'editor_script' => 'custom-video-gallery',
		'editor_style'  => 'custom-video-gallery',
		//'style'         => 'custom-newsletter-block',
	));
}

add_action('init', 'custom_video_gallery');


/**
 * Embed template
 */
function custom_embed_template() {
	// automatically load dependencies and version
	$asset_file = include(get_stylesheet_directory() . '/dist/embedTemplate.asset.php');

	wp_register_script(
		'custom-embed-template',
		get_stylesheet_directory_uri() . '/dist/embedTemplate.js',
		$asset_file['dependencies'],
		$asset_file['version']
		//filemtime(get_stylesheet_directory() . '/dist/imageBlock.js')
	);

	wp_register_style(
		'custom-embed-template',
		get_stylesheet_directory_uri() . '/assets/javascript/blocks/embedTemplate/style.css',
		[],
		filemtime(get_stylesheet_directory() . '/assets/javascript/blocks/embedTemplate/style.css'),
		'all'
	);

	register_block_type('jeo-theme/embed-template', array(
		'editor_script' => 'custom-embed-template',
		'editor_style'  => 'custom-embed-template',
		//'style'         => 'custom-newsletter-block',
	));
}

add_action('init', 'custom_embed_template');


/**
 * Content box
 */
function content_box_template() {
	// automatically load dependencies and version
	$asset_file = include(get_stylesheet_directory() . '/dist/contentBox.asset.php');

	wp_register_script(
		'content-box',
		get_stylesheet_directory_uri() . '/dist/contentBox.js',
		$asset_file['dependencies'],
		$asset_file['version']
		//filemtime(get_stylesheet_directory() . '/dist/imageBlock.js')
	);

	wp_register_style(
		'content-box',
		get_stylesheet_directory_uri() . '/assets/javascript/blocks/contentBox/style.css',
		[],
		filemtime(get_stylesheet_directory() . '/assets/javascript/blocks/contentBox/style.css'),
		'all'
	);

	register_block_type('jeo-theme/content-box', array(
		'render_callback' => 'content_box_render_callback',
		'editor_script' => 'content-box',
		'editor_style'  => 'content-box',
	));
}

function content_box_render_callback($block_attributes, $content) {
	$final_result = '<div class="content-box">';
	$final_result .= '	<h2 class="content-box--title">'. get_theme_mod('content_box_title') .'</h2>';
	$final_result .= '	'. $content;
	$final_result .= '</div>';

	return $final_result;
}

add_action('init', 'content_box_template');

/**
 * Image Gallery
 */
function custom_image_gallery_block() {

	// automatically load dependencies and version
	$asset_file = include(get_stylesheet_directory() . '/dist/imageGallery.asset.php');

	wp_register_script(
		'custom-image-gallery-block',
		get_stylesheet_directory_uri() . '/dist/imageGallery.js',
		$asset_file['dependencies'],
		$asset_file['version']
		//filemtime(get_stylesheet_directory() . '/dist/imageBlock.js')
	);

	wp_register_style(
		'custom-image-gallery-block',
		get_stylesheet_directory_uri() . '/assets/javascript/blocks/imageGallery/dashboard.css',
		[],
		filemtime(get_stylesheet_directory() . '/assets/javascript/blocks/imageGallery/dashboard.css'),
		'all'
	);


	register_block_type('jeo-theme/custom-image-gallery-block', array(
		'editor_script' => 'custom-image-gallery-block',
		'editor_style'  => 'custom-image-gallery-block',
	));
}

add_action('init', 'custom_image_gallery_block');