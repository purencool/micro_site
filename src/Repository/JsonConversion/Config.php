<?php

namespace App\Repository\JsonConversion;

use App\Repository\Utilities\Paths;

/**
 * The LayoutArrayBuilder completes the following functions.
 *  1. Collates all the layouts into one large array.
 *  2. Stores array in layout cache to be used by system.
 *
 * @author purencool
 */
class Config implements ConfigInterface {
  /*   * ```
   * @inheritDoc
   */

  public function setConfigArray(): array {
    try {
      $configFile = Paths::getSiteCacheTest() . 'config.json';
      if (file_exists($configFile) === true) {
        $returnInfo = ' The confing.json file exits';
        $configData = serialize(json_decode(file_get_contents($configFile)));
        $fp = fopen(Paths::getSiteCacheTest() . 'config.php', 'w');
        fwrite($fp, $configData);
        fclose($fp);
      }
    }
    catch (Exception $ex) {
      $returnInfo = $ex->getMessage();
    }




    return [
      ' config array',
      ' set layout two array',
      "$returnInfo"
    ];
  }

}
