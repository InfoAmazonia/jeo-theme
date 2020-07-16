<?php
require __DIR__ . '/inc/generic-css-injection.php';
require __DIR__ . '/inc/template-tags.php';
require __DIR__ . '/inc/api.php';
require __DIR__ . '/inc/newspack-functions-overwrites.php';
require __DIR__ . '/inc/widgets.php';
require __DIR__ . '/inc/metaboxes.php';
require __DIR__ . '/inc/gutenberg-blocks.php';


add_filter('post_link', 'custom_get_permalink', 10, 3);

function custom_get_permalink($url, $post, $leavename = false) {
	$external_source_link = get_post_meta($post->ID, 'external-source-link', true);
	if ($external_source_link) {
		return $external_source_link;
	}

	return $url;
}

add_filter('pre_get_posts', '_search_pre_get_posts', 1);

function _search_pre_get_posts($query) {
	global $wp_query;
	//var_dump();

	if (is_admin() || !$query->is_main_query()) {
		return $query;
	}

	if (isset($query->query['p']) && strpos($query->query['p'], ':redirect') > 0) {
		$query->query['p'] = intval($query->query['p']);
		$query->is_404 = false;
		$query->is_page = true;
		$query->is_home = false;
	}


	if ($query->is_search() && $query->is_main_query()) {
		//$query->set('post_type', [$query->query['post_type']]);
		// Date filter
		if (isset($_GET['daterange'])) {
			$date_range = explode(' - ', $_GET['daterange'], 2);
			if (sizeof($date_range) == 2) {
				$from_date = date_parse($date_range[0]);
				$to_date   = date_parse($date_range[1]);
				$after  = null;
				$before = null;

				if ($from_date && checkdate($from_date['month'], $from_date['day'], $from_date['year'])) {
					$after = array(
						'year'  => $from_date['year'],
						'month' => $from_date['month'],
						'day'   => $from_date['day'],
					);
				}
				// Same for the "to" date.
				if ($to_date && checkdate($to_date['month'], $to_date['day'], $to_date['year'])) {
					$before = array(
						'year'  => $to_date['year'],
						'month' => $to_date['month'],
						'day'   => $to_date['day'],
					);
				}


				$date_query = array();
				if ($after) {
					$date_query['after'] = $after;
				}
				if ($before) {
					$date_query['before'] = $before;
				}
				if ($after || $before) {
					$date_query['inclusive'] = true;
				}

				if (!empty($date_query)) {
					$query->set('date_query', $date_query);
				}
			}
		}

		if (isset($_GET['order'])) {
			$order_option = $_GET['order'];
			$query->set('orderby', 'date');

			if ($order_option == 'ASC' || $order_option == 'DESC') {
				$query->set('order', $_GET['order']);
			}
			//var_dump($query);
		}

		if(isset($_GET['topic'])) {
			$query->set('category_name', $_GET['topic']);
		}

		if(isset($_GET['region']) && !empty($_GET['region'])) {
			if(!empty($query->get('category_name'))) {
				$query->set('category_name', $query->get('category_name') . '+'. $_GET['region']);
			} else {
				$query->set('category_name', $_GET['region']);
			}
			
		}

		//var_dump($query);

	}
	return $query;
}
