<?php

namespace App\Controller\Observers;

/**
 * Mesh combines the layout with the content.
 *
 * @author purencool
 */
class Mesh {

 // private static function findContentPlaceholder($array, $content){
  //   foreach

 // }

  /**
   * runMesh combines the layout with the content.
   * 
   * @param array $layout
   *    Layout out array.
   * @param object $content
   *    Content array.
   * @return array
   *    Return meshed array.
   */
  private static function runMesh(array &$layout, object $content, string $layoutKey) {

    foreach ($layout as $key => $layoutArrayChild) {
      if ($key === $layoutKey) {
        foreach ($layoutArrayChild as $contentKey => $contentValue) {
          if ($contentKey == '@content_placeholder') {
            print_r($content); exit;
            $layoutArrayChild['@content_placeholder'] = $content->{$layoutKey};
            break;
          }
         }   
        $layout[$key] =$layoutArrayChild;    
      }
      else {
        if (is_array($layoutArrayChild)) {
          $layout[$key] = self::runMesh($layoutArrayChild, $content, $layoutKey);
        }
      }
    }
    return $layout;
  }

  /**
   * setMesh combines the layout with the content.
   * 
   * @param array $layout
   *    Layout out array.
   * @param array $content
   *    Content array.
   * @return array
   *    Return meshed array.
   */
  public static function setMesh(array $layout, array $content): array {
 
    foreach ($content as $item) {
      if (is_object($item)) {
        self::runMesh($layout, $item->{'@data'}, array_keys((array) $item->{'@data'})[0]);
      }
    }
    print '<pre>';
    print_r($layout);
    exit;
    return $layout;
  }

}
