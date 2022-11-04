<?php

namespace App\Controller\Observers;

/**
 * HtmlCreation is use to access the test cache objects.
 *
 * @author purencool
 */
class HtmlCreation {

  /**
   * HtmlCreation is use to access the test cache objects.
   * 
   * @param array $dataArray
   *    Data array to be modified.
   * @return array
   *    Return array changes.
   */
  public static function setChanges(array $dataArray): string {
    $return = '';
    foreach ($dataArray['preprocessor'] as $key => $item) {
      $output = str_replace('_', '-', $key);
      $return .= "<div id=\"id-app-$output\" class=\"app-$output\"  >";
      foreach ($item as $keyList => $itemsList) {
        if (array_key_exists('@data', $itemsList)) {
          $return .= implode('', $itemsList['@data']);
        }
      }
      $return .= "</div>";
    }

    return $return;
  }

}
