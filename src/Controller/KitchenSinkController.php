<?php

namespace Drupal\kitchen_sink\Controller;

use Drupal\Core\Controller\ControllerBase;

class KitchenSinkController extends ControllerBase {
  
  /**
   * Displays a html file defined by the given name.
   *
   * @param string $name
   *   Name of the template file. Contains raw user input.
   *
   * @return array
   *   Renderable array.
   */
  public function page($name = 'default') {
    $name = preg_replace('/[^a-zA-Z0-9-_]+/', '', $name);
  
    $template = $this->getTemplate($name);
    if (file_exists($template)) {
      ob_start();
      include $template;
      $contents = ob_get_contents();
      ob_end_clean();
    
      $markup = $contents;
    }
    else {
      $markup = $this->t('Unable to find template for %name.', [
        '%name' => $name,
      ]);
    }
    
    return array(
      '#markup' => $markup,
    );
  }
  
  /**
   * Returns the most likely template file path for the given name.
   *
   * @param string $name
   *   Name of the template file.
   *
   * @return string
   *   Template file path.
   */
  function getTemplate($name = 'default') {
    $template_path = $this->getTemplatePath($name, 'php');
    if (file_exists($template_path)) {
      return $template_path;
    }
    
    $template_path = $this->getTemplatePath($name, 'html');
    if (file_exists($template_path)) {
      return $template_path;
    }
    
    $template_path = $this->getTemplatePath('default', 'php');
    if (file_exists($template_path)) {
      return $template_path;
    }
    
    return $this->getTemplatePath('default', 'html');
  }
  
  /**
   * Returns a template file's path for a given name and extension.
   *
   * @param string $name
   *   Name of the template file.
   * @param string $extension
   *   Template file extension.
   *
   * @return string
   *   Path to the template file.
   */
  private function getTemplatePath($name = 'default', $extension = 'html') {
    $theme = \Drupal::service('theme.manager')->getActiveTheme();
    
    $templates_path = $theme->getPath() . DIRECTORY_SEPARATOR;
    $templates_path .= 'kitchen-sink' . DIRECTORY_SEPARATOR;
    $templates_path .= $name . '.' . $extension;
    
    return $templates_path;
  }
  
  
}

