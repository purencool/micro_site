<?php

namespace App\Repository\Utilities;

/**
 * Description of RemoveDirectoryAndFiles
 *
 * @author purencool
 */
class RemoveDirectoryAndFiles {

   public static function deleteSD($path){
      try{
        $iterator = new \DirectoryIterator($path);
        foreach ( $iterator as $fileinfo ) {
          if($fileinfo->isDot())continue;
          if($fileinfo->isDir()){
            if(self::deleteSD($fileinfo->getPathname()))
              @rmdir($fileinfo->getPathname());
          }
          if($fileinfo->isFile()){
            @unlink($fileinfo->getPathname());
          }
        }
      } catch ( \Exception $e ){
         // write log
         return false;
      }
      return true;
    }
}
