<?php

namespace PopupPlugin;

trait SingletonInstance {
  // Variable to singleton instance
  private static $instance = null;

  // Function to generate singleton instance.
  public static function get_instance() {
    if (self::$instance === null) {
      self::$instance = new self();
    }

    return self::$instance;
  }
}
