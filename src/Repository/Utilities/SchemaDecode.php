<?php

namespace App\Repository\Utilities;

/**
 * Description of GetListOffFiles
 *
 * @author purencool
 */
class SchemaDecode{

  public static function requestObject($scheama, $storage = 'file') {

     if($storage === 'database') {
        return 'database object';
     }

     return unserialize(file_get_contents($scheama));
  }
}
