<?php

namespace Drupal\kitchen_sink\Controller;

use Drupal\Core\Controller\ControllerBase;

class KitchenSinkController extends ControllerBase {
  
  /**
   * TODO
   *
   * @param string $name
   *   TODO
   *
   * @return array
   *   TODO
   */
  public function page($name = 'default') {
    return array(
      '#markup' => kitchen_sink_display_template($name),
    );
  }
  
}

