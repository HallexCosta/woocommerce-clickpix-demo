<?php

class RWMBMetaBoxAdapter {

  public static $meta_boxes;

  public static function run(
    $meta_boxes
  ) {
    self::$meta_boxes = $meta_boxes;

    add_filter('rwmb_meta_boxes', [__CLASS__, 'registerAllMetaBoxes']);
  }

  public static function registerAllMetaBoxes() {
    return self::$meta_boxes;
  }
}
