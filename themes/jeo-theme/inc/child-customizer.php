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

	// Typography
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
			'default'  => 'em',
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
