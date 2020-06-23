<?php
/**
 * Newpack Scott: Customizer
 *
 * @package Newspack Scott
 */

/**
 * Remove the 'Style Pack' customizer option.
 */
function newspack_scott_customizer( $wp_customize ) {
	$wp_customize->remove_control( 'active_style_pack' );

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
				'label' => __( 'Background color', 'newspack' ),
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
				'label'       => esc_html__( 'Background image', 'newspack' ),
				'description' => esc_html__( 'Upload an image to be used as header background. Choosing a background image and background color causes overlap.', 'newspack' ),
				'section'     => 'header_section_appearance',
				'settings'    => 'header_background_image',
				'flex_width'  => false,
				'flex_height' => true,
				'width'       => 400,
				'height'      => 300,
			)
		)
	);
	
	// Typography
	$wp_customize->add_section(
		'typo_heading_sizes',
		array(
			'title' => esc_html__( 'Heading sizes', 'newspack' ),
		)
	);

	$wp_customize->add_setting(
		'typo_h1_size',
		array(
			'default'  => 'initial',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	// change this strategy to range and unit select  https://developer.wordpress.org/themes/customize-api/customizer-objects/
	$wp_customize->add_control(
		'typo_h1_size',
		array(
			'type'        => 'text',
			'description' => __('Don\'t forget about the unit. Ex.: 18px'),
			'label'       => esc_html__('H1', 'newspack'),
			'section'     => 'typo_heading_sizes',
		)
	);

	$wp_customize->add_setting(
		'typo_h2_size',
		array(
			'default'  => 'initial',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'typo_h2_size',
		array(
			'type'        => 'text',
			'label'       => esc_html__('H2', 'newspack'),
			'section'     => 'typo_heading_sizes',
		)
	);
}
add_action( 'customize_register', 'newspack_scott_customizer' );
