<?php
namespace PopupPlugin;

use PopupPlugin\PopupInterface;
use PopupPlugin\SingletonInstance;

class Popup implements PopupInterface {
  use SingletonInstance;

  private function __construct() {
    add_action('wp_body_open', [$this, 'add_popup_root_div']);
    add_action('init', [$this, 'register_post_type']);
    add_action('add_meta_boxes', [$this, 'add_meta_boxes']);
    add_action('save_post', [$this, 'save_meta_boxes']);
    add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
  }

  public function add_popup_root_div() {
    echo '<div id="popup-root"></div>';
  }

  public function register_post_type() {
    register_post_type('popup', [
      'labels'        => ['name' => 'Popups', 'singular_name' => 'Popup'],
      'public'        => true,
      'show_in_rest'  => true,
      'has_archive'   => false,
      'supports'      => ['title', 'editor'],
      'menu_icon'     => 'dashicons-format-image',
    ]);
  }

  public function add_meta_boxes() {
    add_meta_box(
      'popup_page',
      'Select Page for Pop Up',
      [$this, 'render_meta_box'],
      'popup',
      'side',
      'default');
  }

  public function render_meta_box($post) {
    $selected_page = get_post_meta($post->ID, '_popup_page', true);
    $pages = get_pages();

    echo '<select name="popup_page">';
    echo '<option value="">Select a Page</option>';
    foreach ($pages as $page) {
      echo '<option value="' . $page->ID . '" ' . selected($selected_page, $page->ID, false) . '>' . $page->post_title . '</option>';
    }
    echo '</select>';
  }

  public function save_meta_boxes($post_id) {
    if (isset($_POST['popup_page'])) {
      update_post_meta(
        $post_id,
        '_popup_page',
        sanitize_text_field($_POST['popup_page'])
      );
    }
  }

  public function enqueue_scripts() {
    wp_enqueue_script(
      'popup-js',
      plugins_url('../../assets/js/bundle.js', __FILE__),
      ['wp-element'],
      false,
      true
    );

    wp_localize_script(
      'popup-js',
      'wp_data',
      [
        'page_id' => get_queried_object_id(),
        'nonce' => wp_create_nonce('wp_rest'),
        'isLoggedIn' => is_user_logged_in(),
      ]
    );

    wp_enqueue_style(
        'popup-plugin-css',
        plugins_url('../../assets/css/popup.css', __FILE__),
        [],
        false
    );
  }
}
