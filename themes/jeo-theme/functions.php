<?php
require __DIR__ . '/inc/generic-css-injection.php';
require __DIR__ . '/inc/template-tags.php';
require __DIR__ . '/inc/api.php';
require __DIR__ . '/inc/post-types.php';
require __DIR__ . '/inc/newspack-functions-overwrites.php';
require __DIR__ . '/inc/widgets.php';
require __DIR__ . '/inc/metaboxes.php';
require __DIR__ . '/inc/gutenberg-blocks.php';
require __DIR__ . '/inc/menus.php';
require __DIR__ . '/classes/ajax-pv.php';
require __DIR__ . '/classes/library_related-posts.php';



add_filter('post_link', 'custom_get_permalink', 10, 3);

function custom_get_permalink($url, $post, $leavename = false) {
	$external_source_link = get_post_meta($post->ID, 'external-source-link', true);
	if ($external_source_link) {
		return $external_source_link;
	}

	return $url;
}

add_action('after_setup_theme', 'jeo_setup');

function jeo_setup() {
	load_theme_textdomain('jeo', get_stylesheet_directory() . '/lang');
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
		} else {
			$query->set('orderby', 'date');
			$query->set('order', 'DESC');
		}

		$categories = "";


		if (isset($_GET['topic']) && !empty($_GET['topic'])) {
			$categories .= implode(",", $_GET['topic']);
		}

		if (!empty($categories)) {
			$categories .= ",";
		}

		if (isset($_GET['region']) && !empty($_GET['region'])) {
			$categories .= implode(",", $_GET['region']);
		}

		// echo $categories;

		if (!empty($categories)) {
			$query->set('category_name', $categories);
		}

		//var_dump($query);

	}

	return $query;
}

add_filter('pre_get_posts', 'feed_rss_filter', 2);
function feed_rss_filter($query) {
	if ($query->is_feed) {
		$query->set('meta_query', array(
			'relation' => 'OR',
			array(
				'key'     => 'external-source-link',
				'compare' => 'NOT EXISTS',
			),

			array(
				'key'     => 'external-source-link',
				'value'   => '',
				'compare' => '=',
			),
		));
	}

	return $query;
}



function ns_filter_avatar($avatar, $id_or_email, $size, $default, $alt, $args) {
	$headers = @get_headers($args['url']);
	if (!preg_match("|200|", $headers[0])) {
		return;
	}
	return $avatar;
}
add_filter('get_avatar', 'ns_filter_avatar', 10, 6);

if (!function_exists('jeo_comment_form')) {
	function jeo_comment_form() {
		comment_form([
			'logged_in_as' => null,
			'title_reply' => null,
		]);
	}
}

function remove_website_field($fields) {
	unset($fields['url']);
	return $fields;
}
add_filter('comment_form_default_fields', 'remove_website_field');


// its suppose to fix (https://github.com/WordPress/gutenberg/issues/18098)
global $wp_embed;
add_filter('the_content', array($wp_embed, 'autoembed'), 9);

add_filter('comment_form_fields', 'move_comment_field');
function move_comment_field($fields) {
	$comment_field = $fields['comment'];
	unset($fields['comment']);
	$fields['comment'] = $comment_field;
	return $fields;
}


function wpseo_no_show_article_author_facebook($facebook) {
	if (is_single()) {
		return false;
	}
	return $facebook;
}
add_filter('wpseo_opengraph_author_facebook', 'wpseo_no_show_article_author_facebook', 10, 1);

function get_term_for_default_lang($term, $taxonomy) {
	global $icl_adjust_id_url_filter_off;

	$term_id = is_int($term) ? $term : $term->term_id;

	$default_term_id = (int) icl_object_id($term_id, $taxonomy, true, 'en');

	$orig_flag_value = $icl_adjust_id_url_filter_off;

	$icl_adjust_id_url_filter_off = true;
	$term = get_term($default_term_id, $taxonomy);
	$icl_adjust_id_url_filter_off = $orig_flag_value;

	return $term;
}


function get_term_for_lang($term, $taxonomy, $land_code) {
	global $icl_adjust_id_url_filter_off;

	$term_id = is_int($term) ? $term : $term->term_id;

	$default_term_id = (int) icl_object_id($term_id, $taxonomy, true, $land_code);

	$orig_flag_value = $icl_adjust_id_url_filter_off;

	$icl_adjust_id_url_filter_off = true;
	$term = get_term($default_term_id, $taxonomy);
	$icl_adjust_id_url_filter_off = $orig_flag_value;

	return $term;
}

/* Script 1: Migrated Blog Post (infoamazonia) */
if (!get_option('migrated-blog-post')) {
	add_option('migrated-blog-post', 1);

	$queryA = new WP_Query([
		'post_type' => 'blog-post',
		'posts_per_page' => -1,
		'suppress_filters' => true
	]);

	while ($queryA->have_posts()) {
		$queryA->the_post();

		$post_id =  get_the_ID();
		$post_language = wpml_get_language_information($post_id)['language_code'];
		$english_opinion_term = get_term_by('slug', 'opinion', 'category');

		// This term is relative to the current post translation
		$opinion_term_translated = get_term_for_lang($english_opinion_term, 'category', $post_language);


		// var_dump($english_opinion_term);
		// var_dump($opinion_term_translated);


		// Set post type to simple post
		set_post_type($post_id, 'post');

		// Add translated opinion term
		wp_set_object_terms($post_id, $opinion_term_translated->term_id, 'category', true);
	}
}

/* Script 2: Migrated Geolocation meta (infoamazonia / Ekuatorial) */
if(!get_option('migrated-geolocation-meta')){
	add_option('migrated-geolocation-meta', 1);
	
	$query = new WP_Query([
		'posts_per_page' => -1,
		'suppress_filters' => true,
		'meta_query' => array(
			array(
					'key' => 'geocode_latitude',
				'value'   => array(''),
				'compare' => 'NOT IN'
			),
	    ),

	]);

	while ( $query->have_posts() ) {
		$query->the_post();

		$source_lat = get_post_meta(get_the_ID(), 'geocode_latitude', true);
		$source_lon = get_post_meta(get_the_ID(), 'geocode_longitude', true);
		$source_geocode = get_post_meta(get_the_ID(), 'geocode_address', true);

		// Build "_related_point" object
		$related_point = array(
			'_geocode_lat' => $source_lat,
			'_geocode_lon' => $source_lon,
			'relevance' => 'primary',
			'_geocode_full_address' => $source_geocode

		);

		update_post_meta( get_the_ID(), '_related_point', $related_point );
	}
}

/*Script 3: for Mekong Eye - migration - external link */
$wpdb->prefix;

function publisher_mee_query() {
	global $wpdb;
	if(!get_option('external-link')){

			/*1. Get all distinct pub_name and set them as term 'partner' - taxonomy 'partner' */
			add_option('external-link', 1);
			$publishers = $wpdb->get_results("SELECT distinct meta_value from $wpdb->postmeta WHERE (meta_key = 'pub_name')");
			foreach($publishers as $publisher){
				$newpartner = wp_insert_term( $publisher->meta_value, 'partner');
			}
	

			/*2. Get all posts that has filled url field */
			$query = new WP_Query([
				'posts_per_page' => -1,
				'meta_query' => array(
					array(
						'key' => 'url',
						'value'   => array(''),
						'compare' => 'NOT IN'
					),
				),
			]);
	
			while ( $query->have_posts() ) {
				$query->the_post();
				$id = get_the_ID();
	
				$pub_name = get_post_meta($id, 'pub_name', true);
				$url = get_post_meta($id, 'url', true);

				if ($pub_name) {
					$partner = get_term_by('name', $pub_name, 'partner');
				} else {
					$partner = get_term_by('slug','general-publisher', 'partner');
				}
	
				// add partner taxonomy to post
				wp_set_object_terms(get_the_ID(),$partner->term_id, 'partner');
	
				// update meta: external title , external source link
				update_post_meta($id, 'external-title', $partner->name);
				update_post_meta($id, 'external-source-link', $url);
			}
	  }
	}
add_action( 'init', 'publisher_mee_query' );

/* Script 4: Move Topic to tag*/
function move_topic_to_tag() {
	/* List of topic */
	$tax = array( 'agriculture',
	'biodiversity',
	'climate',
	'dams',
	'energy',
	'environment',
	'fishery',
	'forests',
	'gender',
	'global-context',
	'health',
	'human-rights',
	'industry',
	'infrastructure',
	'investment',
	'land-grab',
	'lead',
	'media',
	'mining',
	'oil-gas',
	'policy',
	'pollution',
	'renewable',
	'society-community',
	'tourism',
	'transportation',
	'water-management',
	'wildlife');

	if (!get_option('topic-tag')) {
		add_option('topic-tag', 1);
		$queryA = new WP_Query([
			'post_type'         => 'post',
			'posts_per_page' => -1,
			'tax_query' => array(
				array(
					'taxonomy' => 'topic',
					'field' => 'slug',
					'terms' => $tax,
				)
			),
		]);
	

		while ($queryA->have_posts()) {
			$queryA->the_post();
	
			$post_id =  get_the_ID();
			echo $post_id ;

			$topics_list = get_the_terms($post_id, 'topic');
		
			foreach($topics_list as $topic){
				if(!has_tag($topic->slug)){
					wp_set_post_tags( $post_id , $topic->slug, true );
				}
			}
		}
	}
}
add_action('init', 'move_topic_to_tag'); 
