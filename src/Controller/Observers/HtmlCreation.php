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

    foreach ($dataArray['layout_data_combined'] as $key => $item) {
      $output = str_replace('_', '-', $key);
      $return .= "<div id=\"id-app-$output\" class=\"app-$output\"  >";
      foreach ((array) $item as $keyList => $itemsList) {
        if ($keyList == '@data') {
          $return .= implode('', $itemsList);
        }
        elseif (is_object($itemsList)) {
          $return .= implode('', $itemsList->{'@data'});
        } else {
          // $return .= 'data';
        }
      }

      $return .= "</div>";
    }

    return $return;
  }

}
