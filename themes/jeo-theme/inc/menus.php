<?php
function custom_menus() {
    register_nav_menu('main-menu', __('More', 'jeo'));
}

add_action('init', 'custom_menus');
