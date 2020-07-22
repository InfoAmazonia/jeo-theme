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

	wp_register_style(
		'custom-image-block-block',
		get_stylesheet_directory_uri() . '/assets/javascript/blocks/imageBlock/style.css',
		array(),
		filemtime(get_stylesheet_directory() . '/assets/javascript/blocks/imageBlock/style.css'),
		'all',
	);

	register_block_type('jeo-theme/custom-image-block-editor', array(
		'editor_script' => 'custom-image-block-editor',
		'editor_style'  => 'custom-image-block-editor',
		'style'         => 'custom-image-block-block',
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

	// wp_register_style(
	// 	'custom-newsletter-block-style',
	// 	get_stylesheet_directory_uri() . '/assets/javascript/blocks/newsletter/style.css',
	// 	array(),
	// 	filemtime(get_stylesheet_directory() . '/assets/javascript/blocks/newsletter/style.css'),
	// 	'all',
	// );

	register_block_type('jeo-theme/custom-newsletter-block', array(
		'editor_script' => 'custom-newsletter-block',
		'editor_style'  => 'custom-newsletter-block',
		'style'         => 'custom-newsletter-block',
	));
}

add_action('init', 'custom_newsletter_block');