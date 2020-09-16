<?php
/*
Plugin Name: JEO API
Plugin URI: http://jeowp.org/jeo-api
Description: Plug a GeoJSON API into your JEO project
Version: 0.0.3
Author: Miguel Peixe
Author URI: http://jeowp.org/
License: MIT
*/

if(!class_exists('JEO_API_Plugin')) {

  class JEO_API_Plugin {

    public function __construct() {

      add_action('after_setup_theme', array($this, 'reset_api'), 100);
      add_action('init', array($this, 'init'));


    }

    public static function activate() {
      // Do nothing
    }

    public static function deactivate() {
      // Do nothing
    }

    public function get_dir() {
      return apply_filters('jeo_api_dir', plugin_dir_url(__FILE__));
    }

    public function get_path() {
      return apply_filters('jeo_api_path', dirname(__FILE__));
    }

    // Deactivate theme's native GeoJSON API
    function reset_api() {
      if(class_exists('JEO_API')) {
        remove_filter('jeo_settings_tabs', array($GLOBALS['jeo_api'], 'admin_settings_tab'));
        remove_filter('jeo_settings_form_sections', array($GLOBALS['jeo_api'], 'admin_settings_form_section'));
        if(function_exists('jeo_get_options')) {
          $options = jeo_get_options();
          if($options && isset($options['api']) && $options['api']['enable']) {
            $options['api']['enable'] = false;
            update_option('jeo_settings', $options);
          }
        }
      }
    }

    function is_enabled() {
      if($this->options && $this->options['enabled'])
        return true;
      else
        return false;
    }

    function init() {

      $this->options = get_jeo_api_options();

      if($this->is_enabled()) {

        add_rewrite_endpoint('geojson', EP_ALL);

        add_filter('query_vars', array($this, 'query_var'));
        add_filter('jeo_markers_geojson', array($this, 'jsonp_callback'));
        add_filter('jeo_markers_geojson_key', array($this, 'geojson_key'));
        add_filter('jeo_markers_geojson_keys', array($this, 'geojson_keys'));
        add_filter('jeo_markers_cache_key', array($this, 'cache_key'));
        add_filter('jeo_geojson_content_type', array($this, 'content_type'));
        add_action('jeo_markers_before_print', array($this, 'headers'));
        add_action('pre_get_posts', array($this, 'pre_get_posts'));
        add_filter('jeo_marker_data', array($this,'marker_data'), 200);
        add_action('template_redirect', array($this, 'template_redirect'));

      }

    }

    function get_options() {
      $options = jeo_get_options();
      if($options && isset($options['api'])) {
        return $options['api'];
      }
    }

    function query_var($vars) {
      $vars[] = 'geojson';
      $vars[] = 'download';
      $vars[] = 'from';
      $vars[] = 'to';
      return $vars;
    }

    function pre_get_posts($query) {
      if(isset($query->query['geojson'])) {
        if(!$query->get('map'))
          $query->set('without_map_query', true);
        $query->set('offset', null);
        $query->set('nopaging', null);
        $query->set('paged', (get_query_var('paged')) ? get_query_var('paged') : 1);
        $query->set('meta_query', array(
          array(
            'key' => 'geocode_latitude',
            'value' => '',
            'compare' => '!='
          )
        ));
        if($query->get('from')) {
          $date_query = array(
            array(
              'after' => str_replace(' ', '+', $query->get('from'))
            )
          );
          if($query->get('to')) {
            $date_query[0]['before'] = str_replace(' ', '+', $query->get('to'));
          }
          $query->set('date_query', $date_query);
        }
      }
    }

    function geojson_key($key) {
      global $wp_query;
      if(isset($wp_query->query['geojson'])) {
        $key = '_jeo_api';
      }
      return $key;
    }

    function geojson_keys($keys) {
      $keys[] = '_jeo_api';
      return $keys;
    }

    function cache_key($key) {
      global $wp_query;
      if(isset($wp_query->query['geojson'])) {
        $key .= '_jeo_api';
      }
      return $key;
    }

    function marker_data($properties) {
      global $wp_query;
      if(isset($wp_query->query['geojson'])) {
        // unset unwanted properties
        unset($properties['postID']);
        unset($properties['class']);
        unset($properties['marker']);
        unset($properties['id']);
        unset($properties['range_slider_property']);
        unset($properties['bubble']);
        // set new properties
        $properties['id'] = get_the_ID();
        $properties['date'] = get_the_date('c');
        $properties['excerpt'] = get_the_excerpt();
        if($this->options['fields'] && in_array('taxonomy', $this->options['fields'])) {
          $properties['taxonomy'] = $this->get_taxonomy_data();
        }
        if($this->options['fields'] && in_array('thumbnail', $this->options['fields']) && has_post_thumbnail()) {
          $properties['thumbnail'] = $this->get_thumbnail_data();
        }
      }
      return $properties;
    }

    function get_taxonomy_data() {
      global $post;
      $options = get_jeo_api_options();
      $taxonomies = $options['taxonomies'];
      $post_tax_terms = array();
      foreach($taxonomies as $tax) {
        $terms = wp_get_post_terms($post->ID, $tax);
        if($terms) {
          $tax_terms = array(
            'name' => $tax,
            'terms' => array()
          );
          foreach($terms as $term) {
            $tax_terms['terms'][] = array(
              'id' => $term->term_id,
              'slug' => $term->slug,
              'name' => $term->name
            );
          }
          $post_tax_terms[] = $tax_terms;
        }
      }
      return $post_tax_terms;
    }

    function get_thumbnail_data() {
      global $post;
      $thumb = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
      $full = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
      return array(
        'width' => $thumb[1],
        'height' => $thumb[2],
        'url' => $thumb[0],
        'full' => $full[0]
      );
    }

    function template_redirect() {
      global $wp_query;
      global $jeo_markers;
      if(isset($wp_query->query['geojson'])) {
        $query = $jeo_markers->query();
        $jeo_markers->get_data(apply_filters('jeo_geojson_api_query', $query));
        exit;
      }
    }

    function jsonp_callback($geojson) {
      global $wp_query;
      if(isset($wp_query->query['geojson']) && isset($_GET['callback'])) {
        $jsonp_callback = preg_replace('/[^a-zA-Z0-9$_]/s', '', $_GET['callback']);
        $geojson = "$jsonp_callback($geojson)";
      }
      return $geojson;
    }

    function content_type($content_type) {
      global $wp_query;
      if(isset($wp_query->query['geojson']) && isset($_GET['callback'])) {
        $content_type = 'application/javascript';
      }
      return $content_type;
    }

    function headers() {
      global $wp_query;
      if(isset($wp_query->query['geojson'])) {
        header('X-Total-Count: ' . $wp_query->found_posts);
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Max-Age: 1000');
        if(isset($_GET['download'])) {
          $filename = apply_filters('jeo_geojson_filename', sanitize_title(get_bloginfo('name') . ' ' . wp_title(null, false)));
          header('Content-Disposition: attachment; filename="' . $filename . '.geojson"');
        }
      }
    }

    function get_api_url($query_args = array()) {
      global $wp_query;
      $query_args = (empty($query_args)) ? $wp_query->query : $query_args;
      $query_args = $query_args + array('geojson' => 1);
      return add_query_arg($query_args, home_url('/'));
    }

    function get_download_url($query_args = array()) {
      return add_query_arg(array('download' => 1), $this->get_api_url($query_args));
    }

  }

}

if(class_exists('JEO_API_Plugin')) {

  register_activation_hook(__FILE__, array('JEO_API_Plugin', 'activate'));
  register_deactivation_hook(__FILE__, array('JEO_API_Plugin', 'deactivate'));

  $jeo_api_plugin = new JEO_API_Plugin();

}

include_once($jeo_api_plugin->get_path() . '/settings.php');
