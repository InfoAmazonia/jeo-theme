<?php


/**
 * Prints HTML with meta information for the current post-date/time.
 */
function newspack_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf(
		$time_string,
		esc_attr( get_the_date( DATE_W3C ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( DATE_W3C ) ),
		esc_html( get_the_modified_date() )
	);

	if ( is_single() ) { ?>
		<div class="post-date">
				<?php the_date('F j, Y') ?>
				<?php if(get_the_date() != get_the_modified_date() || get_the_time() != get_the_modified_time()): ?>
				-  (Updated <?= the_modified_date("F j, Y \a\\t G:i") ?>) 
				<?php endif ?>


		</div>

		
	<?php
	} else {
		printf(
		'<span class="posted-on"><a href="%1$s" rel="bookmark">%2$s</a></span>',
			esc_url( get_permalink() ),
			wp_kses(
				$time_string,
				array(
					'time' => array(
						'class'    => array(),
						'datetime' => array(),
					),
				)
			)
		);
	}
}
/**
 * Prints HTML with meta information about theme author.
 */
function newspack_posted_by() {
	if ( function_exists( 'coauthors_posts_links' ) ) :

		$authors      = get_coauthors();
		$author_count = count( $authors );
		$i            = 1;

		foreach ( $authors as $author ) {
			if ( 'guest-author' === get_post_type( $author->ID ) ) {
				if ( get_post_thumbnail_id( $author->ID ) ) {
					$author_avatar = coauthors_get_avatar( $author, 80 );
				} else {
					// If there is no avatar, force it to return the current fallback image.
					$author_avatar = get_avatar( ' ' );
				}
			} else {
				$author_avatar = coauthors_get_avatar( $author, 80 );
			}

			//echo '<span class="author-avatar">' . wp_kses( $author_avatar, newspack_sanitize_avatars() ) . '</span>';
		}
		?>

		<span class="byline">
			<span><?php echo esc_html__( 'by', 'newspack' ); ?></span>
			<?php
			foreach ( $authors as $author ) {

				$i++;
				if ( $author_count === $i ) :
					/* translators: separates last two author names; needs a space on either side. */
					$sep = esc_html__( ' and ', 'newspack' );
				elseif ( $author_count > $i ) :
					/* translators: separates all but the last two author names; needs a space at the end. */
					$sep = esc_html__( ', ', 'newspack' );
				else :
					$sep = '';
				endif;

				printf(
					/* translators: 1: author link. 2: author name. 3. variable seperator (comma, 'and', or empty) */
					'<span class="author vcard"><a class="url fn n" href="%1$s">%2$s</a></span>%3$s ',
					esc_url( get_author_posts_url( $author->ID, $author->user_nicename ) ),
					esc_html( $author->display_name ),
					esc_html( $sep )
				);
			}
			?>
		</span><!-- .byline -->
	<?php
	else :
		printf(
			/* translators: 1: Author avatar. 2: post author, only visible to screen readers. 3: author link. */
			'<span class="author-avatar">%1$s</span><span class="byline"><span>%2$s</span> <span class="author vcard"><a class="url fn n" href="%3$s">%4$s</a></span></span>',
			get_avatar( get_the_author_meta( 'ID' ) ),
			esc_html__( 'by', 'newspack' ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_html( get_the_author() )
		);

	endif;
}