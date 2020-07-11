<?php
/**
 * Newspack Scott: Typography
 *
 * @package Newspack Scott
 */
/**
 * Generate the CSS for custom typography.
 */
function newspack_scott_custom_typography_css() {
	$font_body   = newspack_font_stack( get_theme_mod( 'font_body', '' ), get_theme_mod( 'font_body_stack', 'serif' ) );
	$font_header = newspack_font_stack( get_theme_mod( 'font_header', '' ), get_theme_mod( 'font_header_stack', 'serif' ) );

	$css_blocks        = '';
	$editor_css_blocks = '';



	if ( get_theme_mod( 'font_header', '' ) ) {
		$css_blocks .= '
			.has-drop-cap:not(:focus)::first-letter,
			.wp-block-pullquote,
			.wp-block-pullquote cite {
				font-family: ' . wp_kses( $font_header, null ) . ';
			}
		';

		$editor_css_blocks .= '
			.block-editor-block-list__layout .block-editor-block-list__block.has-drop-cap:not(:focus)::first-letter,
			.block-editor-block-list__layout .block-editor-block-list__block.wp-block[data-type="core/pullquote"] blockquote > .editor-rich-text p,
			.block-editor-block-list__layout .block-editor-block-list__block.wp-block[data-type="core/pullquote"] p,
			.block-editor-block-list__layout .block-editor-block-list__block.wp-block[data-type="core/pullquote"] .wp-block-pullquote__citation,
			.block-editor-block-list__layout .block-editor-block-list__block.wp-block[data-type="core/pullquote"] blockquote > .editor-rich-text__editable:first-child::before {
				font-family: ' . wp_kses( $font_header, null ) . ';
			}
		';
	}
	if ( true === get_theme_mod( 'accent_allcaps', true ) ) {
		$css_blocks        .= '
			.accent-header:not(.widget-title),
			.article-section-title,
			.page-title,
			#secondary .widget-title,
			.author-bio .accent-header span,
			#colophon .widget-title {
				text-transform: uppercase;
			}
		';
		$editor_css_blocks .= '
			.block-editor-block-list__layout .block-editor-block-list__block .accent-header,
			.block-editor-block-list__layout .block-editor-block-list__block .article-section-title {
				text-transform: uppercase;
			}
		';
	}

	if ( '' !== $css_blocks ) {
		$theme_css = $css_blocks;
	} else {
		$theme_css = '';
	}

	if ( '' !== $editor_css_blocks ) {
		$editor_css = $editor_css_blocks;
	} else {
		$editor_css = '';
	}

	if ( function_exists( 'register_block_type' ) && is_admin() ) {
		$theme_css = $editor_css;
	}


	$font_unit = get_theme_mod('typo_unit', 'em');
	$forced_size = get_theme_mod('typo_important')? '!important' : '';

	$theme_css .= '
		h1 {
			font-size: ' . get_theme_mod('typo_h1_size', '2') . $font_unit . $forced_size . ';
		}

		.single-post h1.entry-title{
			font-size: ' . get_theme_mod('typo_h1_size', '2') . $font_unit . $forced_size . ';
		}

		h2 {
			font-size: ' . get_theme_mod('typo_h2_size', '1.5') . $font_unit . $forced_size . ';
		}

		h3 {
			font-size: ' . get_theme_mod('typo_h3_size', '1.17') . $font_unit . $forced_size . ';
		}

		.wp-block-cover .wp-block-pullquote p {
			font-size: ' . get_theme_mod('typo_h3_size', '1.17') . $font_unit . '!important' . ';
			line-height: inherit;
		}
		

		h4 {
			font-size: ' . get_theme_mod('typo_h4_size', '1') . $font_unit . $forced_size . ';
		}

		h5 {
			font-size: ' . get_theme_mod('typo_h5_size', '0.83') . $font_unit . $forced_size . ';
		}

		h6 {
			font-size: ' . get_theme_mod('typo_h6_size', '0.67') . $font_unit . $forced_size . ';
		}

		p {
			font-size: ' . get_theme_mod('typo_p_size', '1') . $font_unit . $forced_size . ';
		}

		.wp-block-pullquote p{
			font-size: ' . get_theme_mod('typo_p_size', '1') . $font_unit . '!important'. ';
        }

		figure.wp-block-pullquote.alignright.has-background.is-style-solid-color p,
.		figure.wp-block-pullquote.alignright.has-background.is-style-solid-color p{
			font-size: ' . get_theme_mod('typo_p_size', '1') . $font_unit . '!important'. ';
        }
	';

	if (!empty(get_theme_mod( 'accent_font', ''))) {
		$accent_font = wp_kses( get_theme_mod( 'accent_font'), null );

		$theme_css .= '
		.accent-header:not(.widget-title), .article-section-title, .page-title, #secondary .widget-title, .author-bio .accent-header span, #colophon .widget-title, .tags-links span:first-child, .single .cat-links {
			font-family: "' . $accent_font . '", "sans-serif";
		}

		:root {
			--accent-font: "' . $accent_font . '", "sans-serif";
		}
		';
	}

	if (!empty(get_theme_mod( 'single_featured_font', ''))) {
		$featured_font = wp_kses( get_theme_mod( 'single_featured_font'), null );
		$default_font = get_theme_mod('font_body');

		$theme_css .= '
		.single .entry-title, .page .entry-header .entry-title, .single .main-content, 
		.page .main-content{
			font-family: "' . $featured_font . '", "sans-serif";
		}

		:root {
			--featured-font: "' . $featured_font . '", "sans-serif";
			--primary-font: "' . $default_font . '", "sans-serif";
		}

		';
	}


	if (!empty(get_theme_mod( 'site_description_color', ''))) {
		$color = get_theme_mod( 'site_description_color');

		$theme_css .= '
		:root {
			--description-color: '. $color . ';
		}

		';
	}


	if (!empty(get_theme_mod( 'search_icon_color', ''))) {
		$color = get_theme_mod( 'search_icon_color');

		$theme_css .= '
		:root {
			--search-icon-color: '. $color . ';
		}

		';
	}

	return $theme_css;
}
