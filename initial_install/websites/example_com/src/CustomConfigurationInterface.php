<?php
namespace App\CacheTest;

/**
 *
 * @author purencool
 */
interface CustomConfigurationInterface {
  
  /**
   * Implements array of object for customer changes
   * 
   * @return array
   *    Returns an array of objects
   */
  public function getObjectArray(): array;
}