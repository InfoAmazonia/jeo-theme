<?php



class API {
    /**
     * Dumps error
     *
     * @param array $message error message. default "Message not suplied"
     * @return array
     */
    private static function dump_error($message = "Message not suplied") {
        return ['error' => $message];
    }

    static function get_external_title($params) {
        $external_link = $params['target_link'];

        $args = array(
            'posts_per_page'   => 1,
            'orderby'          => 'post_date',
            'order'            => 'DESC',
            'post_status'      => 'publish',
            'meta_query' => array(
                array(
                    'key'     => 'external-source-link',
                    'value'   => array( $external_link ),
                    'compare' => 'IN',
                ),
            ),
        );
        
        $found_posts = get_posts( $args );
        return $found_posts;
    }

    static function construct_endpoints() {
        add_action( 'rest_api_init', function () {
            register_rest_route( 'api', '/external-link', array(
                'methods' => 'GET',
                'callback' => 'API::get_external_title',
                'args' => [
                    'target_link' => array(
                        'required' => true,
                        //'validate_callback' => 'API::validate_medal_slug'
                    ),
                ],
            ) );
        } );
    }

}

API::construct_endpoints();