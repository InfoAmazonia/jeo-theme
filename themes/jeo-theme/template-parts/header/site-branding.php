<?php
/**
 * Displays header site branding
 *
 * @package Newspack
 */

    $header_center_logo  = get_theme_mod( 'header_center_logo', false );
?>

<div class="site-branding">

    <?php
        newspack_the_custom_logo();
		if ( false === $header_center_logo) :
    ?>

        <div class="site-identity">
            <?php $blog_info = get_bloginfo( 'name' ); ?>
            <?php if ( ! empty( $blog_info ) ) : ?>
                <?php if ( is_front_page() && is_home() ) : ?>
                    <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                <?php else : ?>
                    <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
                <?php endif; ?>
            <?php endif; ?>

            <?php
            $description = get_bloginfo( 'description', 'display' );
            if ( $description || is_customize_preview() ) :
                ?>
                    <p class="site-description">
                        <?php echo $description; /* WPCS: xss ok. */ ?>
                    </p>
            <?php endif; ?>
        </div><!-- .site-identity -->
    
	<?php endif; ?>

</div><!-- .site-branding -->
