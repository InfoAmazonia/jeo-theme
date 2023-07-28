<?php

function add_reviewer_role () {
	if (!get_option('added_reviewer_role')) {
		add_role('reviewer', __('Reviewer', 'plenamata-theme'), [
			'read' => true,
			'read_private_pages' => true,
			'read_private_posts' => true,
			'upload_files' => true,
		]);
		update_option('added_reviewer_role', '1');
	}
}
add_action('init', 'add_reviewer_role');