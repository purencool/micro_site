<?php

namespace App\Controller\Observers;

/**
 * HtmlCreation is use to access the test cache objects.
 *
 * @author purencool
 */
class HtmlCreation {

  /**
   * HtmlCreation flattens an array into a string.
   * 
   * @param array $dataArray
   *    Data array to be modified.
   * @return string
   *    Return strings of flatten array.
   */
  public static function setChanges(array $dataArray): string {
    $return = '';
    $setSchemaDiv = false;
    $setPlaceHolderDiv = false;
    foreach ($dataArray as $key => $item) {
      if (!is_object($item)) {
        if (!is_string($item)) {
          $output = str_replace('_', '-', $key);
          if (strpos($key, '@schema') !== false) {
            $setSchemaDiv = true;
            $return .= "";
          }
          elseif (strpos($key, '@content_placeholder') !== false) {
            $setPlaceHolderDiv = true;
            $return .= "";
          }
          else {
            if (strpos($key, '@') !== false) {
              $outputAt = str_replace('@', '-', $output);
              $return .= "<div class=\"app-$outputAt\"  >";
            }
            else {
              $return .= "<div id=\"id-app-$output\" class=\"app-$output\"  >";
            }
          }

          if (array_key_exists('@data', $item)) {
            $return .= implode('', $item['@data']);
          }
          else {
            $return .= self::setChanges($item);
          }

          if ($setSchemaDiv == true) {
            $setSchemaDiv == false;
            $return .= "";
          }
          elseif ($setPlaceHolderDiv == true) {
            $setPlaceHolderDiv = false;
            $return .= "";
          }
          else {
            $return .= "</div>";
          }
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
