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
}
add_action( 'customize_register', 'newspack_scott_customizer', 99 );
