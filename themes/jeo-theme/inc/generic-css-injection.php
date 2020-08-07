<?php

function generic_css_injection($starter = "")
{
	$decoration_style = get_theme_mod('decoration_style', 'square');

	if ($decoration_style !== 'square') {
		if ($decoration_style == 'top') {
			$starter .= '
				.accent-header:not(.widget-title)::before, .article-section-title::before, .cat-links::before, .page-title::before {
					display: block;
					height: 3px;
					width: 30px;    
					margin-bottom: 10px;                
				}
			';
		} else if ($decoration_style == 'left') {
			$starter .= '
				.accent-header:not(.widget-title)::before, .article-section-title::before, .cat-links::before, .page-title::before {
					width: 3px;    
					margin-right: 20px;
					height: auto;
				}

				.article-section-title, .cat-links {
					display: flex;
				}
			';
		} else if ($decoration_style == 'eye') {
			$starter .= '
				.accent-header:not(.widget-title)::before, .article-section-title::before, .cat-links::before, .page-title::before {
					width: 16px;    
					height: 16px;
					margin-right: 20px;
					background-image: url('. get_stylesheet_directory_uri() . "/assets/images/icons/eye.svg" . ');
					background-size: 16px;
    				background-repeat: no-repeat;
    				background-color: transparent!important;
				}

			';
		}
	}


?>

	<style type="text/css" id="custom-generic-css">
		<?php echo $starter ?>
	</style>

<?php
}

add_action('wp_head', 'generic_css_injection');


function fontawesome_back_editor() {
	wp_enqueue_style('jeo-theme-fontawesome', "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css", array(), '5.12.0', 'all');
}
add_action('enqueue_block_editor_assets', 'fontawesome_back_editor');
