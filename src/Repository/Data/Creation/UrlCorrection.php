<?php

namespace App\Repository\Data\Creation;


/**
 * Creates UrlCorrection for content and layouts
 *
 * @author purencool
 */
class UrlCorrection {

   public static function testRoute($routeName){
        // Testing route is not the front page(/).
        if (strlen($routeName) === 1) {
          return $routeName;
        }
        return rtrim($routeName, '/');
   }

}
