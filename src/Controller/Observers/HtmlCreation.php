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
    foreach ($dataArray as $key => $item) {
      if (!is_object($item)) {
        if (!is_string($item)) {
           $output = str_replace('_', '-', $key);
          if (strpos($key, '@') !== false) {
            $outputAt = str_replace('@', '-', $output);
            $return .= "<div class=\"app-$outputAt\"  >";
          }
          else {
            $return .= "<div id=\"id-app-$output\" class=\"app-$output\"  >";
          }

          if (array_key_exists('@data', $item)) {
            $return .= implode('', $item['@data']);
          }
          else {
            $return .= self::setChanges($item);
          }
          $return .= "</div>";
        }
        else {

          $return .= $item;
        }
      }
      else {
        foreach (get_object_vars($item) as $strings) {
          $return .= "<div>$strings</div>";
        }
      }
    }

    return $return;
  }

}
