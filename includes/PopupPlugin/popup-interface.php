<?php

namespace PopupPlugin;

interface PopupInterface {
  public function register_post_type();
  public function add_meta_boxes();
  public function save_meta_boxes($post_id);
}
