<?php
function register_metaboxes() {
	add_meta_box(
		'display-autor-info',
		'Show author options',
		'display_author_callback',
		['post', 'project'],
		'side',
		'default',
	);

	add_meta_box(
		'republish-post',
		'Republish post',
		'republish_post_callback',
		['post', 'project'],
		'side',
		'default',
	);

	add_meta_box(
		'hide-post-excerpt',
		'Post excerpt',
		'hide_post_excerpt_callback',
		['post', 'project'],
		'side',
		'default',
	);

	add_meta_box(
		'media-partner-republish',
		'Media partner republished link',
		'media_partner_republish_callback',
		'post',
		'side',
		'default',
	);

	add_meta_box(
		'twitter-opinion-video',
		'Twitter video preview',
		'twitter_opinion_video_callback',
		'post',
		'side',
		'default',
	);

	add_meta_box(
		'project-link',
		'Project Link',
		'project_link_callback',
		'project',
		'side',
		'default',
	);

	add_meta_box(
		'erratum-block',
		__('Sorry, we said wrong', 'jeo'),
		'display_erratum_block',
		'post'
	);

	add_meta_box(
		'external-post',
		'External post',
		'display_external_post_callback',
		'post',
		'side',
		'default',
	);
}

function is_edit_page($new_edit = null){
    global $pagenow;
    //make sure we are on the backend
    if (!is_admin()) return false;


    if($new_edit == "edit")
        return in_array( $pagenow, array( 'post.php',  ) );
    elseif($new_edit == "new") //check for new post page
        return in_array( $pagenow, array( 'post-new.php' ) );
    else //check for either new or edit
        return in_array( $pagenow, array( 'post.php', 'post-new.php' ) );
}

function project_link_callback() {
	$jeo_stored_meta = get_post_meta(get_the_ID());	
	?>

		<p>
			<div class="jeo-row-content">
				<label for="project-link">
					<input placeholder="Requires https:// or http//" style="width: 100%" type="text" name="project-link" id="project-link" value="<?php if (isset($jeo_stored_meta['project-link'])) echo $jeo_stored_meta['project-link'][0]; ?>"  />
				</label>
			</div>
		</p>

<?php
}

function display_author_callback() {
	wp_nonce_field(basename(__FILE__), 'jeo_nonce');
	$jeo_stored_meta = get_post_meta(get_the_ID());
?>

	<p>
		<!-- <span class="jeo-row-title"><?php _e('Authors biography: ', 'jeo') ?></span> -->
		<div class="jeo-row-content">
			<label for="author-bio-display">
				<input type="checkbox" name="author-bio-display" id="author-bio-display" value="false" <?php if (isset($jeo_stored_meta['author-bio-display'])) checked($jeo_stored_meta['author-bio-display'][0], true); ?> />
				<?php _e('Authors biography', 'jeo') ?>
			</label>

		</div>
	</p>

	<p>
		<!-- <span class="jeo-row-title"><?php _e('Authors listing: ', 'jeo') ?></span> -->
		<div class="jeo-row-content">
			<label for="authors-listing">
				<input type="checkbox" name="authors-listing" id="authors-listing" value="false" <?php if (isset($jeo_stored_meta['authors-listing'])) checked($jeo_stored_meta['authors-listing'][0], true); ?> />
				<?php _e('Authors listing', 'jeo') ?>
			</label>

		</div>
	</p>

<?php
}

function republish_post_callback() {
	wp_nonce_field(basename(__FILE__), 'jeo_nonce');
	$jeo_stored_meta = get_post_meta(get_the_ID());

	global $wp_registered_widgets;	
	$widgets = wp_get_sidebars_widgets(); 
	$bullet_widget = array_key_exists('republish_modal_bullets', $widgets)? $widgets['republish_modal_bullets'] : null;
	$bullets = [];

	if($bullet_widget) {
		$bullet_widget = $bullet_widget[0];
		if (isset($wp_registered_widgets[$bullet_widget])) {
			$bullets = $wp_registered_widgets[$bullet_widget]['callback'][0]->get_settings();
		}
	}
	
?>

	<p>
		<!-- <span class="jeo-row-title"><?php _e('Add republish link: ', 'jeo') ?></span> -->
		<div class="jeo-row-content">
			<label for="republish_post">
				<?php if(is_edit_page('new')): ?>
					<?php if(get_theme_mod('republish_in_all_posts', false)): ?>			
						<input type="checkbox" name="republish_post" id="republish_post" value="false" checked />
					<?php else: ?>
						<input type="checkbox" name="republish_post" id="republish_post" value="false" <?php if (isset($jeo_stored_meta['republish_post'])) checked($jeo_stored_meta['republish_post'][0], true); ?> />
					<?php endif; ?>
				<?php else: ?>
					<input type="checkbox" name="republish_post" id="republish_post" value="false" <?php if (isset($jeo_stored_meta['republish_post'])) checked($jeo_stored_meta['republish_post'][0], true); ?> />
				<?php endif; ?>
				<?php _e('Add republish link', 'jeo') ?>
			</label>

		</div>
	</p>
	<p class="bullets-metaboxes-title">
		<span class="jeo-row-title"><?php _e('Bullets: ', 'jeo') ?></span>
	</p>
	<div class="republish-posts-bullets">
		<?php foreach($bullets as $bullet): ?>
			<p class="bullet-paragraph">
				<div class="jeo-row-content">
					<label for="<?php echo str_replace(' ', '_', $bullet['title']); ?>">
						<input type="checkbox" name="<?php echo str_replace(' ', '_', $bullet['title']); ?>" id="<?php echo str_replace(' ', '_', $bullet['title']); ?>" value="false" <?php if (isset($jeo_stored_meta[str_replace(' ', '_', $bullet['title'])])) checked($jeo_stored_meta[str_replace(' ', '_', $bullet['title'])][0], true); ?> />
						<?php _e($bullet['title'], 'jeo') ?>
					</label>

				</div>
			</p>
		<?php endforeach; ?>
	</div>

<?php
}

function hide_post_excerpt_callback() {
	wp_nonce_field(basename(__FILE__), 'jeo_nonce');
	$jeo_stored_meta = get_post_meta(get_the_ID());
?>

	<p>
		<!-- <span class="jeo-row-title"><?php _e('Hide post excerpt: ', 'jeo') ?></span> -->
		
		<div class="jeo-row-content">
			<label for="hide_post_excerpt">
					<?php _e('If the generic option to hide posts in Customizer Panel is enabled, it will replace this option', 'jeo') ?>
					<br><br>
					<input type="checkbox" name="hide_post_excerpt" id="hide_post_excerpt" value="false" <?php if (isset($jeo_stored_meta['hide_post_excerpt'])) checked($jeo_stored_meta['hide_post_excerpt'][0], true); ?> />
				<?php _e('Hide post excerpt', 'jeo') ?>
			</label>

		</div>
	</p>
<?php
}

function twitter_opinion_video_callback() {
	wp_nonce_field(basename(__FILE__), 'jeo_nonce');
	$jeo_stored_meta = get_post_meta(get_the_ID());	
	?>

		<p>
			<span class="jeo-row-title"><?php _e('Video URL to be shown on twitter sharing preview: ', 'jeo') ?></span>
			<div class="jeo-row-content">
				<label for="twitter-opinion-video">
					<input placeholder="Requires https:// or http//" type="text" name="twitter-opinion-video" id="twitter-opinion-video" value="<?php if (isset($jeo_stored_meta['twitter-opinion-video'])) echo $jeo_stored_meta['twitter-opinion-video'][0]; ?>"  />
				</label>
			</div>
		</p>

<?php
}

function media_partner_republish_callback() {
	wp_nonce_field(basename(__FILE__), 'jeo_nonce');
	$jeo_stored_meta = get_post_meta(get_the_ID());	
	?>

		

	<p>
		<div class="jeo-row-content">
			<label for="partner-link">
				<?php _e('Media partner link (It works with selected media partners)', 'jeo') ?>
				<br><br>
				<input placeholder="Requires https:// or http//" type="text" style="width: 100%" name="partner-link" id="partner-link" value="<?php if (isset($jeo_stored_meta['partner-link'])) echo $jeo_stored_meta['partner-link'][0]; ?>" />
			</label>

		</div>
	</p>

<?php
}

function display_erratum_block() {
	wp_nonce_field(basename(__FILE__), 'jeo_nonce');
	$jeo_stored_meta = get_post_meta(get_the_ID());
?>

	<p>
		<span class="jeo-row-title"><?php _e('Check to enable the "sorry we said wrong": ', 'jeo') ?></span>
		<div class="jeo-row-content">
			<label for="enable-post-erratum">
				<input type="checkbox" name="enable-post-erratum" id="enable-post-erratum" value="false" <?php if (isset($jeo_stored_meta['enable-post-erratum'])) checked($jeo_stored_meta['enable-post-erratum'][0], true); ?> />
				<?php _e('Sorry we said wrong', 'jeo') ?>
			</label>
			<p>
				<label for="post-erratum">
					<textarea style="width: 100%" name="post-erratum" id="post-erratum"><?php if (isset($jeo_stored_meta['post-erratum'])) echo $jeo_stored_meta['post-erratum'][0]; ?></textarea>
				</label>
			</p>

		</div>
	</p>

<?php
}

function display_external_post_callback() {
	wp_nonce_field(basename(__FILE__), 'jeo_nonce');
	$jeo_stored_meta = get_post_meta(get_the_ID());
?>

	<p>
		<div class="jeo-row-content">
			<?php _e('You must select a media partner to use as original publisher name', 'jeo') ?>
			<br><br>
			<label for="external-source-link">
				<?php _e('Original Publisher link', 'jeo') ?>
				<input placeholder="Requires https:// or http//"  type="text" style="width: 100%" name="external-source-link" id="external-source-link" value="<?php if (isset($jeo_stored_meta['external-source-link'])) echo $jeo_stored_meta['external-source-link'][0]; ?>" />
			</label>

		</div>
	</p>

<?php
}

/**
 * Saves the custom meta input
 */
function meta_save($post_id) {

	//Republish post function variables
	global $wp_registered_widgets;
	$widgets = wp_get_sidebars_widgets(); 
	
	$bullet_widget = array_key_exists('republish_modal_bullets', $widgets)? $widgets['republish_modal_bullets'] : null;
	$bullets = [];

	if($bullet_widget) {
		$bullet_widget = $bullet_widget[0];
		if (isset($wp_registered_widgets[$bullet_widget])) {
			$bullets = $wp_registered_widgets[$bullet_widget]['callback'][0]->get_settings();
		}
	}


	// Checks save status - overcome autosave, etc.
	$is_autosave = wp_is_post_autosave($post_id);
	$is_revision = wp_is_post_revision($post_id);
	$is_valid_nonce = (isset($_POST['jeo_nonce']) && wp_verify_nonce($_POST['jeo_nonce'], basename(__FILE__))) ? 'true' : 'false';

	// Exits script depending on save status
	if ($is_autosave || $is_revision || !$is_valid_nonce || defined( 'DOING_CRON' )) {
		return;
	}

	// Checks for input and saves - save checked as yes and unchecked at no
	if (isset($_POST['author-bio-display'])) {
		update_post_meta($post_id, 'author-bio-display', true);
	} else {
		update_post_meta($post_id, 'author-bio-display', false);
	}

	if (isset($_POST['authors-listing'])) {
		update_post_meta($post_id, 'authors-listing', true);
	} else {
		update_post_meta($post_id, 'authors-listing', false);
	}

	if (isset($_POST['republish_post'])) {
		update_post_meta($post_id, 'republish_post', true);
	} else {
		update_post_meta($post_id, 'republish_post', false);
	}

	if (isset($_POST['hide_post_excerpt'])) {
		update_post_meta($post_id, 'hide_post_excerpt', true);
	} else {
		update_post_meta($post_id, 'hide_post_excerpt', false);
	}

	if (isset($_POST['partner-link'])) {
		update_post_meta($post_id, 'partner-link', $_POST['partner-link']);
	}

	if (isset($_POST['enable-post-erratum'])) {
		update_post_meta($post_id, 'enable-post-erratum', true);
	} else {
		update_post_meta($post_id, 'enable-post-erratum', false);
	}

	if (isset($_POST['post-erratum'])) {
		update_post_meta($post_id, 'post-erratum', $_POST['post-erratum']);
	}

	if (isset($_POST['external-source-link'])) {
		update_post_meta($post_id, 'external-source-link', $_POST['external-source-link']);
	}

	if (isset($_POST['twitter-opinion-video'])) {
		update_post_meta($post_id, 'twitter-opinion-video', $_POST['twitter-opinion-video']);
	}

	if (isset($_POST['external-title'])) {
		update_post_meta($post_id, 'external-title', $_POST['external-title']);
	}

	if (isset($_POST['project-link'])) {
		update_post_meta($post_id, 'project-link', $_POST['project-link']);
	}

	foreach($bullets as $bullet){
		if (isset($_POST[str_replace(' ', '_', $bullet['title'])])) {
			update_post_meta($post_id, str_replace(' ', '_', $bullet['title']), true);
		} else {
			update_post_meta($post_id, str_replace(' ', '_', $bullet['title']), false);
		}
		
	}
}

add_action('save_post', 'meta_save');
add_action('add_meta_boxes', 'register_metaboxes');