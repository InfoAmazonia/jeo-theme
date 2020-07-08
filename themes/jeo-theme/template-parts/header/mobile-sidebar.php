<?php
/**
 * Template to display the mobile navigation, either AMP or fallback.
 *
 * @package Newspack
 */

if ( newspack_is_amp() ) : ?>
	<amp-sidebar id="mobile-sidebar" layout="nodisplay" side="right" class="mobile-sidebar">
		<button class="mobile-menu-toggle" on='tap:mobile-sidebar.toggle'>
			<?php echo wp_kses( newspack_get_icon_svg( 'close', 20 ), newspack_sanitize_svgs() ); ?>
			<?php esc_html_e( 'Close', 'newspack' ); ?>
		</button>
<?php else : ?>
	<aside id="mobile-sidebar-fallback" class="mobile-sidebar">
		<button class="mobile-menu-toggle">
			<?php echo wp_kses( newspack_get_icon_svg( 'close', 20 ), newspack_sanitize_svgs() ); ?>
		</button>
<?php endif; ?>

		<?php

		newspack_primary_menu();
		
		$button_url = get_theme_mod('discovery_button_link'); 

		
		if (!empty($button_url)): ?>
			<ul class="main-menu">
				<li class="menu-item menu-item-type-post_type menu-item-object-page">
					<a href="<?= $button_url ?>" class="discovery-link">
						DISCOVERY
					</a>
				</li>
			</ul>
		<?php endif;

		newspack_tertiary_menu();


		newspack_social_menu_header();
		?>

<?php if ( newspack_is_amp() ) : ?>
	</amp-sidebar>
<?php else : ?>
	</aside>
<?php endif; ?>
