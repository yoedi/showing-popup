<?php

namespace PopupPlugin;

trait SingletonInstance {
  private static $instance = null;

  public static function get_instance() {
    if (self::$instance === null) {
      self::$instance = new self();
    }

    return self::$instance;
  }
}
