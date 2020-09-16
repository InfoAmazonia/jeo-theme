<?php

if(!class_exists('JEO_API_Plugin_Settings')) {

  class JEO_API_Plugin_Settings {

    public function __construct() {

      add_action('admin_menu', array($this, 'admin_menu'));
      add_action('admin_init', array($this, 'init_plugin_settings'));

    }

    function get_options() {
      $options = get_option('jeo_api');
      if(!$options) {
        $options = array(
          'enabled' => false,
          'fields' => array_keys($this->get_fields()),
          'taxonomies' => get_taxonomies(array('public' => true))
        );
      }
      return $options;
    }

    function admin_menu() {
      add_options_page(__('JEO GeoJSON API', 'jeo_api'), __('GeoJSON API', 'jeo_api'), 'manage_options', 'jeo_api', array($this, 'admin_page'));
    }

    function admin_page() {
      $this->options = $this->get_options();
      ?>
      <div class="wrap">
        <?php screen_icon(); ?>
        <h2><?php _e('JEO GeoJSON API', 'newsroom'); ?></h2>
        <form method="post" action="options.php">
          <?php
          settings_fields('jeo_api_settings_group');
          do_settings_sections('jeo_api');
          submit_button();
          ?>
        </form>
      </div>
      <?php
    }

    function init_plugin_settings() {

      /*
       * Settings sections
       */
      add_settings_section(
        'jeo_api_general',
        __('General settings', 'jeo_api'),
        '',
        'jeo_api'
      );

      add_settings_section(
        'jeo_api_fields',
        __('API output fields', 'jeo_api'),
        '',
        'jeo_api'
      );

      add_settings_section(
        'jeo_api_taxonomy',
        __('Taxonomies', 'jeo_api'),
        '',
        'jeo_api'
      );

      /*
       * Settings fields
       */

      add_settings_field(
        'jeo_api_enabled',
        __('Enable API', 'jeo_api'),
        array($this, 'enabled_field'),
        'jeo_api',
        'jeo_api_general'
      );

      add_settings_field(
        'jeo_api_fields',
        __('Fields', 'jeo_api'),
        array($this, 'output_field'),
        'jeo_api',
        'jeo_api_fields'
      );

      add_settings_field(
        'jeo_api_taxonomy',
        __('Taxonomies to display', 'jeo_api'),
        array($this, 'taxonomy_field'),
        'jeo_api',
        'jeo_api_taxonomy'
      );


      // Register
      register_setting('jeo_api_settings_group', 'jeo_api');

    }

    function enabled_field() {
      $enabled = $this->options['enabled'];
      ?>
      <input id="jeo_api_enabled_field" type="checkbox" name="jeo_api[enabled]" value="1" <?php if($enabled) echo 'checked'; ?> />
      <label for="jeo_api_enabled_field"><?php _e('Enable the GeoJSON API', 'jeo_api'); ?></label>
      <?php
    }

    function get_fields() {
      $fields = array(
        'id' => array(
          'name' => 'ID',
          'required' => true
        ),
        'title' => array(
          'name' => __('Title', 'jeo_api'),
          'required' => true
        ),
        'excerpt' => array(
          'name' => __('Excerpt', 'jeo_api'),
          'required' => true
        ),
        'date' => array(
          'name' => __('Date', 'jeo_api'),
          'required' => true
        ),
        'geometry' => array(
          'name' => __('Geometry', 'jeo_api'),
          'required' => true
        ),
        'thumbnail' => array(
          'name' => __('Thumbnail', 'jeo_api'),
          'required' => false
        ),
        'taxonomy' => array(
          'name' => __('Taxonomy', 'jeo_api'),
          'required' => false
        )
      );
      return apply_filters('jeo_api_fields', $fields);
    }

    function output_field() {
      $fields = $this->options['fields'];
      $available = $this->get_fields();
      ?>
      <table>
        <thead>
          <tr>
            <th><?php _e('Name', 'jeo_api'); ?></th>
            <th><?php _e('Enabled', 'jeo_api'); ?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($available as $key => $field) : ?>
            <tr>
              <td><label for="jeo_api_field_<?php echo $key; ?>"><?php echo $field['name']; ?> <i><?php if($field['required']) _e('(required)', 'jeo_api'); ?></i></label></td>
              <td><input id="jeo_api_field_<?php echo $key; ?>" type="checkbox" name="jeo_api[fields][]" value="<?php echo $key; ?>" <?php if($field['required'] || in_array($key, $fields)) echo 'checked'; ?> <?php if($field['required']) echo 'disabled'; ?> /></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <?php
    }

    function taxonomy_field() {
      $taxonomies = $this->options['taxonomies'];
      $available = get_taxonomies(array('public' => true));
      ?>
      <table>
        <thead>
          <tr>
            <th><?php _e('Name', 'jeo_api'); ?></th>
            <th><?php _e('Enabled', 'jeo_api'); ?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($available as $tax) : ?>
            <tr>
              <td><label for="jeo_api_tax_<?php echo $tax; ?>"><?php echo $tax; ?></label></td>
              <td><input id="jeo_api_tax_<?php echo $tax; ?>" type="checkbox" name="jeo_api[taxonomies][]" value="<?php echo $tax; ?>" <?php if(in_array($tax, $taxonomies)) echo 'checked'; ?> /></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <?php
    }

  }

}

if(class_exists('JEO_API_Plugin_Settings')) {
  $jeo_api_plugin_settings = new JEO_API_Plugin_Settings();
}

function get_jeo_api_options() {
  global $jeo_api_plugin_settings;
  if ($jeo_api_plugin_settings !== NULL) {
    return $jeo_api_plugin_settings->get_options();
  }
}
