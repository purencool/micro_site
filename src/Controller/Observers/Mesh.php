<?php

namespace App\Controller\Observers;

/**
 * Mesh combines the layout with the content.
 *
 * @author purencool
 */
class Mesh {

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

    foreach ($layout as $key => $item) {
      if ($key === $layoutKey) {
          $lookingForPlaceHolder = '';
          foreach ($turnIntoArray as $contentKey => $contentValue) {
            if ($contentValue == '@content_placeholder') {
              $lookingForPlaceHolder = $contentKey;
              break;
            }
          }

          if ($lookingForPlaceHolder == '') {
            $layout[$key]['@data'][$key] = $content;
          }
          else {
            $layout[$key]['@data'][$lookingForPlaceHolder] = $content->{$layoutKey};
          }
        }
        else {
          // Helps HtmlCreation creation no throw an error 
          // because HtmlCreation dumps objects as it looks 
          // for arrays to interate over.
                if (is_array($item)) {
        $layout[$key] = self::runMesh($item, $content, $layoutKey);
      } else {
          $layout[$key] = $content;
      }
       
      }

    }
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
    $return = [];

    foreach ($content as $item) {
      if (is_object($item)) {
        self::runMesh($layout, $item, array_keys((array) $item)[0]);
      }
    }

    print_r($layout);
    exit;

    return $return;
  }

}
