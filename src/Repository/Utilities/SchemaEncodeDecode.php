<?php

namespace App\Repository\Utilities;

/**
 * SchemaDecode decode and encodes PHP objects to and from Storage Schema. 
 *
 * @author purencool
 */
class SchemaEncodeDecode {

  /**
   * Get PHP object
   * 
   * @param type $schema
   * @param type $storage
   * @return string
   */
  public static function requestObject($schema, $storage = 'file') {

    if ($storage === 'database') {
      return 'database object';
    }

    return unserialize(file_get_contents($schema));
  }

  /**
   * Get create PHP object and store.
   * 
   * @param type $scheama
   * @param type $storage
   * @return string
   */
  public static function createObject($schema, $data ,$storage = 'file') {

    if ($storage === 'database') {
      return 'database object';
    }

    $newFileName = substr($schema, 0, -4);
    $fp = fopen($newFileName . 'txts', 'w');
    fwrite($fp, $data);
    fclose($fp);
  }

}
