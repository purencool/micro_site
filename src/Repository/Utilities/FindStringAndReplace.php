<?php

namespace App\Repository\Utilities;

/**
 * FindStringAndReplace  finds files and replaces strings.
 *
 * @author purencool
 */
class FindStringAndReplace {

  /**
   * Finds string in file and replaces it.
   * 
   * @param type $filePath
   *     Provides the file path to be open.
   * @param type $findString
   *     Find string in file.
   * @param type $replaceString
   *     Replacement string.
   */
  protected static function changeNameSpace($filePath, $findString, $replaceString) {
    $contentFile = file_get_contents($filePath);
    $contentChunks = explode($findString, $contentFile);
    $content = implode($replaceString, $contentChunks);
    file_put_contents($filePath, $content);
  }

  /**
   * Finds files extensions.
   * 
   * @param type $schema
   *     Provides the directory to be open.
   * @param type $findString
   *     Find string in file.
   * @param type $replaceString
   *     Replacement string.
   * @param type $filesExt
   *     File extensions to find.
   */
  public static function setReplace($schema, $findString, $replaceString, $filesExt = 'php') {
    $iti = new \RecursiveDirectoryIterator($schema);
    foreach (new \RecursiveIteratorIterator($iti) as $item) {
      $ext = pathinfo($item, PATHINFO_EXTENSION);
      if ($ext === $filesExt) {
        self::changeNameSpace($item, $findString, $replaceString);
      }
    }
  }

}
