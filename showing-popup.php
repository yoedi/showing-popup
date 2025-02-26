<?php
/**
 * Plugin Name:     Showing Popup
 * Description:     An plugin to show a pop up in a page
 * Author:          Yoedi Arianto
 * Author URI:      Yoedi Arianto
 * Text Domain:     showing-popup
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Showing_Popup
 */

// Your code starts here.


// A security filter to prevent direct access to the file.
if (!defined('ABSPATH')) {
    exit;
}

// Load necessary files
require_once plugin_dir_path(__FILE__) . 'includes/PopupPlugin/popup-interface.php';
require_once plugin_dir_path(__FILE__) . 'includes/PopupPlugin/singleton-instance.php';
require_once plugin_dir_path(__FILE__) . 'includes/PopupPlugin/popup.php';
require_once plugin_dir_path(__FILE__) . 'includes/PopupPlugin/popup-api.php';

// Initialize Plugin
PopupPlugin\Popup::get_instance();
PopupPlugin\PopupAPI::get_instance();