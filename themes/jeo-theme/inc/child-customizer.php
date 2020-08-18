<?php

/**
 * Newpack Scott: Customizer
 *
 * @package Newspack Scott
 */

/**
 * Remove the 'Style Pack' customizer option.
 */
function newspack_scott_customizer($wp_customize)
{
	$wp_customize->remove_control('active_style_pack');

	// Add backgroud color option to header
	$wp_customize->add_setting(
		'header_background_color_hex',
		array(
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'header_background_color_hex',
			array(
				'label' => __('Background color', 'newspack'),
				'description' => __('Leave empty to use default'),
				'section'     => 'header_section_appearance',
			)
		)
	);

	$wp_customize->add_control(
		'show_author_social',
		array(
		'type' => 'checkbox',
		'label' => esc_html__( 'Display Author Social Media links', 'newspack' ),
		'description' => esc_html__( 'Display social media links with the author bio on individual posts and author archives (this option requires the Yoast plugin).', 'newspack' ),
		'section' => 'author_bio_options',
		)
	);

	// Add background image control and ooption to header
	$wp_customize->add_setting(
		'header_background_image',
		array(
			'default'           => '',
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Cropped_Image_Control(
			$wp_customize,
			'header_background_image',
			array(
				'label'       => esc_html__('Background image', 'newspack'),
				'description' => esc_html__('Upload an image to be used as header background. Choosing a background image and background color causes overlap.', 'newspack'),
				'section'     => 'header_section_appearance',
				'settings'    => 'header_background_image',
				'flex_width'  => false,
				'flex_height' => true,
				'width'       => 400,
				'height'      => 300,
			)
		)
	);

	// use image bg for dark-mode?
	$wp_customize->add_setting(
		'header_image_bg_dark_mode',
		array(
			'default' => true,
		)
	);

	$wp_customize->add_control(
		'header_image_bg_dark_mode',
		array(
		'type' => 'checkbox',
		'label' => esc_html__( 'Use backgroud image in dark mode?', 'jeo' ),
		'description' => esc_html__( 'By disabling this, the header will use the default background with some opacity applied.', 'newspack' ),
		'section' => 'header_section_appearance',
		)
	);

	// Add sticky logo control and ooption to header
	$wp_customize->add_setting(
		'logo_sticky_image',
		array(
			'default'           => '',
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Cropped_Image_Control(
			$wp_customize,
			'logo_sticky_image',
			array(
				'label'       => esc_html__('Logo sticky image', 'newspack'),
				'description' => esc_html__('Upload an image to be used as sticky logo. If there are no sticky logo, the main logo will be used instead', 'newspack'),
				'section'     => 'title_tagline',
				'settings'    => 'logo_sticky_image',
				'flex_width'  => false,
				'flex_height' => true,
				'width'       => 400,
				'height'      => 300,
			)
		)
	);

	// Add darkmode logo control
	$wp_customize->add_setting(
		'logo_dark_image',
		array(
			'default'           => '',
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Cropped_Image_Control(
			$wp_customize,
			'logo_dark_image',
			array(
				'label'       => esc_html__('Logo dark image', 'newspack'),
				'description' => esc_html__('Dark logo to be displayed. The default dark mode logo is your logo masked with white.', 'newspack'),
				'section'     => 'title_tagline',
				'settings'    => 'logo_dark_image',
				'flex_width'  => false,
				'flex_height' => true,
				'width'       => 400,
				'height'      => 300,
			)
		)
	);

	// Discovery button style
	$wp_customize->add_setting(
		'discovery_button_style',
		array(
			'default'  => 'solid',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'discovery_button_style',
		array(
			'type' => 'select',
			'section' => 'header_section_appearance',
			'label' => __('Discovery button style'),
			'default'  => 'solid',
			'choices' => array(
				'solid' => 'Solid',
				'outline' => 'Outline',
			)
		)
	);


	$wp_customize->add_setting(
		'discovery_button_link',
		array(
			'sanitize_callback' => 'wp_filter_nohtml_kses',
		)
	);

	$wp_customize->add_control(
		'discovery_button_link',
		array(
			'label'       => __( 'Discovery button link', 'newspack' ),
			'description' => __( 'Leave it empty to hide.' ),
			'section'     => 'header_section_appearance',
			'default'     => '',
			'type'        => 'text',
		)
	);

	// Site description color options
	$wp_customize->add_setting(
		'site_description_color',
		array(
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'site_description_color',
			array(
				'label' => __('Site description color', 'newspack'),
				'section'     => 'header_section_appearance',
			)
		)
	);

	// Search color options
	$wp_customize->add_setting(
		'search_icon_color',
		array(
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'search_icon_color',
			array(
				'label' => __('Search icon color', 'newspack'),
				'section'     => 'header_section_appearance',
			)
		)
	);

	$wp_customize->add_setting(
		'search_dark_icon_color',
		array(
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'search_dark_icon_color',
			array(
				'label' => __('Search dark icon color', 'newspack'),
				'section'     => 'header_section_appearance',
			)
		)
	);


	$wp_customize->add_setting(
		'social_dark_icon_color',
		array(
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'social_dark_icon_color',
			array(
				'label' => __('Social dark icon color ', 'newspack'),
				'section'     => 'header_section_appearance',
			)
		)
	);

	$wp_customize->add_setting(
		'search_background_option',
		array(
			'default'           => 'default',
			'sanitize_callback' => 'newspack_sanitize_color_option',
		)
	);

	$wp_customize->add_control(
		'search_background_option',
		array(
			'type'    => 'radio',
			'label'   => __( 'Search icon background', 'newspack' ),
			'choices'  => array(
				'default' => 'Default',
				'custom'  => 'Custom',
			),
			'section' => 'header_section_appearance',
		)
	);


	$wp_customize->add_setting(
		'search_icon_bg_color',
		array(
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'search_icon_bg_color',
			array(
				'label' => __('Search icon background color', 'newspack'),
				'section'     => 'header_section_appearance',
			)
		)
	);

	// Decoration style
	$wp_customize->add_setting(
		'decoration_style',
		array(
			'default'  => 'square',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'decoration_style',
		array(
			'type' => 'select',
			'section' => 'title_tagline',
			'label' => __('Decoration marker style'),
			'choices' => array(
				'square' => 'Square',
				'top' => 'Top rectangle',
				'left' => 'Left bar',
				'eye' => 'Mekong eye',
			)
		)
	);

	$wp_customize->add_setting(
		'pagination_style',
		array(
			'default'  => 'rectangle',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'pagination_style',
		array(
			'type' => 'select',
			'section' => 'title_tagline',
			'label' => __('Pagination style'),
			'choices' => array(
				'rectangle' => 'Square',
				'circle' => 'Circle',
			)
		)
	);
	// Typography Heading Desktop
	$wp_customize->add_section(
		'typo_heading_sizes',
		array(
			'title' => esc_html__('Font sizes', 'newspack'),
			'section' => 'newspack_typography',
		)
	);

	$wp_customize->add_setting(
		'typo_unit',
		array(
			'default'  => 'rem',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'typo_unit',
		array(
			'type' => 'select',
			'section' => 'typo_heading_sizes',
			'label' => __('Unit'),
			'choices' => array(
				'px' => 'px',
				'rem' => 'rem',
				'em' => 'em',
			)
		)
	);


	$range_atttrs = array(
		'min' => 1,
		'max' => 65,
		'step' => 1,
	);

	$wp_customize->add_setting(
		'typo_important',
		array(
			'default'  => false,
			'sanitize_callback' => 'newspack_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'typo_important',
		array(
			'type' => 'checkbox',
			'section' => 'typo_heading_sizes',
			'label' => __('Force font-size by using !important'),
		)
	);

	$wp_customize->add_setting(
		'typo_p_size',
		array(
			'default'  => '1',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'typo_p_size',
		array(
			'type' => 'number',
			'section' => 'typo_heading_sizes',
			'label' => __('p'),
			'input_attrs' => $range_atttrs,
		)
	);

	$wp_customize->add_setting(
		'typo_h1_size',
		array(
			'default'  => '2',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'typo_h1_size',
		array(
			'type' => 'number',
			'section' => 'typo_heading_sizes',
			'label' => __('H1'),
			'input_attrs' => $range_atttrs,
		)
	);

	$wp_customize->add_setting(
		'typo_h2_size',
		array(
			'default'  => '1.5',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'typo_h2_size',
		array(
			'type' => 'number',
			'section' => 'typo_heading_sizes',
			'label' => __('H2'),
			'input_attrs' => $range_atttrs,
		)
	);

	$wp_customize->add_setting(
		'typo_h3_size',
		array(
			'default'  => '1.17',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'typo_h3_size',
		array(
			'type' => 'number',
			'section' => 'typo_heading_sizes',
			'label' => __('H3'),
			'input_attrs' => $range_atttrs,
		)
	);

	$wp_customize->add_setting(
		'typo_h4_size',
		array(
			'default'  => '1',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'typo_h4_size',
		array(
			'type' => 'number',
			'section' => 'typo_heading_sizes',
			'label' => __('H4'),
			'input_attrs' => $range_atttrs,
		)
	);

	$wp_customize->add_setting(
		'typo_h5_size',
		array(
			'default'  => '0.83',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'typo_h5_size',
		array(
			'type' => 'number',
			'section' => 'typo_heading_sizes',
			'label' => __('H5'),
			'input_attrs' => $range_atttrs,
		)
	);


	$wp_customize->add_setting(
		'typo_h6_size',
		array(
			'default'  => '0.67',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'typo_h6_size',
		array(
			'type' => 'number',
			'section' => 'typo_heading_sizes',
			'label' => __('H6'),
			'input_attrs' => $range_atttrs,
		)
	);

	// Typography Mobile
	$wp_customize->add_section(
		'typo_heading_sizes_mobile',
		array(
			'title' => esc_html__('Font sizes mobile', 'newspack'),
			'section' => 'newspack_typography',
		)
	);


	$wp_customize->add_setting(
		'typo_unit_mobile',
		array(
			'default'  => 'rem',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'typo_unit_mobile',
		array(
			'type' => 'select',
			'section' => 'typo_heading_sizes_mobile',
			'label' => __('Unit'),
			'choices' => array(
				'px' => 'px',
				'rem' => 'rem',
				'em' => 'em',
			)
		)
	);

	$wp_customize->add_setting(
		'typo_important_mobile',
		array(
			'default'  => false,
			'sanitize_callback' => 'newspack_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'typo_important_mobile',
		array(
			'type' => 'checkbox',
			'section' => 'typo_heading_sizes_mobile',
			'label' => __('Force font-size by using !important'),
		)
	);

	$wp_customize->add_setting(
		'typo_p_size_mobile',
		array(
			'default'  => '1',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'typo_p_size_mobile',
		array(
			'type' => 'number',
			'section' => 'typo_heading_sizes_mobile',
			'label' => __('p'),
			'input_attrs' => $range_atttrs,
		)
	);

	$wp_customize->add_setting(
		'typo_h1_size_mobile',
		array(
			'default'  => '2',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'typo_h1_size_mobile',
		array(
			'type' => 'number',
			'section' => 'typo_heading_sizes_mobile',
			'label' => __('H1'),
			'input_attrs' => $range_atttrs,
		)
	);

	$wp_customize->add_setting(
		'typo_h2_size_mobile',
		array(
			'default'  => '1.5',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'typo_h2_size_mobile',
		array(
			'type' => 'number',
			'section' => 'typo_heading_sizes_mobile',
			'label' => __('H2'),
			'input_attrs' => $range_atttrs,
		)
	);

	$wp_customize->add_setting(
		'typo_h3_size_mobile',
		array(
			'default'  => '1.17',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'typo_h3_size_mobile',
		array(
			'type' => 'number',
			'section' => 'typo_heading_sizes_mobile',
			'label' => __('H3'),
			'input_attrs' => $range_atttrs,
		)
	);

	$wp_customize->add_setting(
		'typo_h4_size_mobile',
		array(
			'default'  => '1',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'typo_h4_size_mobile',
		array(
			'type' => 'number',
			'section' => 'typo_heading_sizes_mobile',
			'label' => __('H4'),
			'input_attrs' => $range_atttrs,
		)
	);

	$wp_customize->add_setting(
		'typo_h5_size_mobile',
		array(
			'default'  => '0.83',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'typo_h5_size_mobile',
		array(
			'type' => 'number',
			'section' => 'typo_heading_sizes_mobile',
			'label' => __('H5'),
			'input_attrs' => $range_atttrs,
		)
	);


	$wp_customize->add_setting(
		'typo_h6_size_mobile',
		array(
			'default'  => '0.67',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'typo_h6_size_mobile',
		array(
			'type' => 'number',
			'section' => 'typo_heading_sizes_mobile',
			'label' => __('H6'),
			'input_attrs' => $range_atttrs,
		)
	);

	// Single font
	$wp_customize->add_setting(
		'single_featured_font',
		array(
			'sanitize_callback' => 'wp_filter_nohtml_kses',
		)
	);

	$wp_customize->add_control(
		'single_featured_font',
		array(
			'label'       => __( 'Featured Font', 'newspack' ),
			'description' => __( 'Example: Libre Basquesville' ),
			'section'     => 'newspack_typography',
			'type'        => 'text',
		)
	);

	// Accent text font 
	$wp_customize->add_setting(
		'accent_font_import_code_alternate',
		array(
			'sanitize_callback' => 'newspack_sanitize_font_provider_url',
		)
	);

	$wp_customize->add_control(
		'accent_font_import_code_alternate',
		array(
			'label'   => __( 'Accent Font Provider Import Code or URL', 'newspack' ),
			'section' => 'newspack_typography',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'accent_font',
		array(
			'sanitize_callback' => 'wp_filter_nohtml_kses',
		)
	);

	$wp_customize->add_control(
		'accent_font',
		array(
			'label'       => __( 'Accent font', 'newspack' ),
			'description' => __( 'Example: Dosis' ),
			'section'     => 'newspack_typography',
			'type'        => 'text',
		)
	);
}
add_action('customize_register', 'newspack_scott_customizer', 99);

//add_action( 'customize_preview_init', 'customize_preview' );

function child_newspack_panels_js() {
	wp_enqueue_script( 'js-customizer-ux', get_stylesheet_directory_uri() . '/assets/javascript/customizer-child.js', array(), filemtime(get_stylesheet_directory() . '/assets/javascript/customizer-child.js'), true   );

}
add_action( 'customize_controls_enqueue_scripts', 'child_newspack_panels_js' );
