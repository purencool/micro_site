<?php

namespace App\Repository\Utilities;



/**
 * Description of ObjectsToArray
 *
 * @author purencool
 */
class ObjectsToArray {

   /**
   * Removes all STD objects and turns them into an array.
   * 
   * @param mixed $obj
   *     Can be arrays or objects.
   * @return mixed
   *     Ultimately returns an array after recursion is
   *     resolved.
   */
  public static function returnObjToArr($obj) {
    if (is_object($obj)) {
      $obj = (array) $obj;
    }
    if (is_array($obj)) {
      $new = array();
      foreach ($obj as $key => $val) {
        $new[$key] = self::returnObjToArr($val);
      }
    }
    else {
      $new = $obj;
    }
    return $new;
  }
}
