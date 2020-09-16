<?php

/*
 * JEO embed tool
 */

class JEO_Embed {

	var $query_var = 'jeo_map_embed';
	var $slug = 'embed';

	function __construct() {
		add_filter('query_vars', array(&$this, 'query_var'));
		add_action('generate_rewrite_rules', array(&$this, 'generate_rewrite_rule'));
		add_action('template_redirect', array(&$this, 'template_redirect'));
	}

	function query_var($vars) {
		$vars[] = $this->query_var;
		return $vars;
	}

	function generate_rewrite_rule($wp_rewrite) {
		$widgets_rule = array(
			$this->slug . '$' => 'index.php?' . $this->query_var . '=1'
		);
		$wp_rewrite->rules = $widgets_rule + $wp_rewrite->rules;
	}

	function template_redirect() {
		if(get_query_var($this->query_var)) {

			// by mohjak: fix #27 https://tech.openinfo.cc/earth/earth/-/issues/27 Shared maps aren't parsing "&amp;" correctly at the URL
			$queryString = $_SERVER['QUERY_STRING'];
			parse_str(htmlspecialchars_decode($queryString), $queryVars);

			// Set embed map
			if(isset($queryVars['map_id'])) {
				jeo_set_map(get_post($queryVars['map_id']));
			} else {
				$maps = get_posts(array('post_type' => 'map', 'posts_per_page' => 1));
				if($maps) {
					jeo_set_map(array_shift($maps));
				} else {
					exit;
				}
			}

			// Set tax
			if(isset($queryVars['tax'])) {
				global $wp_query;
				$wp_query->set('tax_query', array(
					array(
						'taxonomy' => $queryVars['tax'],
						'field' => 'slug',
						'terms' => $queryVars['term']
					)
				));
			}

			add_filter('show_admin_bar', '__return_false');
			do_action('jeo_before_embed');
			$this->template();
			do_action('jeo_after_embed');
			exit;
		}
	}

	function template() {
		wp_enqueue_style('jeo-embed', get_template_directory_uri() . '/inc/css/embed.css');
		get_template_part('content', 'embed');
		exit;
	}

	function get_embed_url($vars = array()) {
		$query = http_build_query($vars);
		return apply_filters('jeo_embed_url', home_url('/' . $this->slug) . '/?' . $query);
	}

	function get_map_conf() {
		$conf = array();
		$conf['containerID'] = 'map_embed';
		$conf['disableHash'] = true;
		$conf['mainMap'] = true;

		// by mohjak: fix #27 https://tech.openinfo.cc/earth/earth/-/issues/27 Shared maps aren't parsing "&amp;" correctly at the URL
		$queryString = $_SERVER['QUERY_STRING'];
		parse_str(htmlspecialchars_decode($queryString), $queryVars);

		if(isset($queryVars['map_id'])) {
			$conf['postID'] = $queryVars['map_id'];
		} else {
			$conf['postID'] = jeo_get_the_ID();
		}
		if(isset($queryVars['map_only'])) {
			$conf['disableMarkers'] = true;
		}
		if(isset($queryVars['layers'])) {
			$conf['layers'] = explode(',', $queryVars['layers']);
			if(isset($conf['postID']))
				unset($conf['postID']);
		}
		if(isset($queryVars['zoom'])) {
			$conf['zoom'] = $queryVars['zoom'];
		}
		if(isset($queryVars['lat']) && isset($queryVars['lon'])) {
			$conf['center'] = array($queryVars['lat'], $queryVars['lon']);
			$conf['forceCenter'] = true;
		}
		$conf['disable_mousewheel'] = false;

		$conf = apply_filters('jeo_map_embed_conf', $conf);

		return apply_filters('jeo_map_embed_geojson_conf', json_encode($conf));
	}
}

$GLOBALS['jeo_embed'] = new JEO_Embed();

function jeo_get_embed_url($vars = array()) {
	return $GLOBALS['jeo_embed']->get_embed_url($vars);
}

function jeo_get_map_embed_conf() {
	return $GLOBALS['jeo_embed']->get_map_conf();
}

