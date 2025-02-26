<?php

namespace PopupPlugin;

use PopupPlugin\SingletonInstance;

class PopupApi {
  use SingletonInstance;

  private function __construct() {
    add_action('rest_api_init', [$this, 'register_rest_api']);
  }

  public function register_rest_api() {
    register_rest_route(
      'artistudio/v1',
      '/popup',
      [
        'methods'             => 'GET',
        'callback'            => [$this, 'get_popup'],
        'permission_callback' => function() {
          return is_user_logged_in();
        },
        'args' => [
          'page_id' => [
            'required' => true,
            'validate_callback' => function($param, $request, $key) {
              return is_numeric($param);
            }
          ]
        ]
      ]
    );
  }

  public function get_popup($request) {
    $page_id = $request->get_param('page_id');
    
    $args = [
      'post_type'   => 'popup',
      'post_status' => ['publish'],
      'meta_query'  => [
        [
          'key' => '_popup_page', 
          'value' => $page_id, 
          'compare' => '='
        ]
      ]
    ];

    $query = new \WP_Query($args);
    
    $popups = [];

    while($query->have_posts()) {
      $query->the_post();
      $popups[] = [
        'title' => get_the_title(),
        'content' => apply_filters('the_content', get_the_content()),
      ];
    }

    wp_reset_postdata();
    return $popups;
  }
}
