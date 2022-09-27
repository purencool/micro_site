<?php

namespace App\Repository\Processes;

use App\Repository\Utilities\RemoveDirectoryAndFiles;

/**
 * The Caches class completes the following functions.
 *  1. Delete caches.
 *  2. Destroy caches.
 *
 * @author purencool
 */
class Caches {

  /**
   * Sets directory separator.
   * 
   * @var string
   */
  protected $ds;

  /**
   * Sets the real path to that applications root.
   * 
   * @var string
   */
  protected $path;

  public function __construct() {
    $this->ds = DIRECTORY_SEPARATOR;
    $this->path =  __DIR__ . $this->ds . ".." . 
           $this->ds . ".." . $this->ds . ".." . $this->ds;
  }
  

  /**
   * Destroy caches.
   * 
   * 
   * @return array
   *    Lets the user know the results of the process.
   */
  public function destroy(): array {
    $path = $this->path .'var' . $this->ds . 'cache';
    RemoveDirectoryAndFiles::deleteSD($path);
    print_r(scandir($path));
    
    echo "destroyed"; exit;
    return ['response' => 'Caches have been destroyed'];
  }


  /**
   * Create caches.
   * 
   * 
   * @return array
   *    Lets the user know the results of the process.
   */
  public function create(): array {
    
    return ['response' => 'Caches have been created'];
  }

}
