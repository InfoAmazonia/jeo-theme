<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Newspack
 */

?>

	<?php do_action( 'before_footer' ); ?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer">

		<?php get_template_part( 'template-parts/footer/footer', 'branding' ); ?>
		<?php get_template_part( 'template-parts/footer/footer', 'widgets' ); ?>

		<div class="site-info">

			<?php get_template_part( 'template-parts/footer/below-footer', 'widgets' ); ?>

			<div class="wrapper site-info-contain">
				<?php
					$custom_copyright = get_theme_mod( 'footer_copyright', '' );
					$has_footer_logo = false;

					if ( '' !== get_theme_mod( 'copyright_logo', '' ) && 0 !== get_theme_mod( 'copyright_logo', '' ) ) {
						$has_footer_logo = true;
					}
				?>

				<?php if ( $has_footer_logo ) : ?>
					<?php
						echo wp_get_attachment_image(
							get_theme_mod( 'copyright_logo', '' ),
							'copyright-logo',
							'',
							array( 'class' => 'footer-logo' )
						);
					?>
				<?php else: ?>
						<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/logos/JEOminip.svg';?>">
				<?php endif; ?>
				
				<span class="copyright"><?php echo esc_html( $custom_copyright ); ?></span>
				<div class="credit">
					<p><?= __('Web development by', 'jeo') ?></p>
					<a href="https://hacklab.com.br" class="hacklab">Hacklab</a>
					<a href="https://hacklab.com.br" class="hacklab-decoration-marker">/</a>
				</div>

				<?php
				if ( function_exists( 'the_privacy_policy_link' ) ) {
					the_privacy_policy_link( '', '' );
				}

				if ( ! is_active_sidebar( 'footer-1' ) || ( ! has_custom_logo() ) ) {
					newspack_social_menu_footer();
				}
				?>
			</div><!-- .wrapper -->
		</div><!-- .site-info -->
	</footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
