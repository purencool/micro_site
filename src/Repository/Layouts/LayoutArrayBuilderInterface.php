<?php

namespace App\Repository\Layouts;


/**
 * The LayoutArrayBuilder completes the following functions.
 *  1. Collates all the layouts into one large array.
 *  2. Stores array in layout cache to be used by system.
 *
 * @author purencool
 */
interface LayoutArrayBuilderInterface {
   
   /**
    * Implements data array for the layout format array
    * 
    * @param String $path
    * @return array
    */
   public function getLayoutArray(String $path) : array ;
}

