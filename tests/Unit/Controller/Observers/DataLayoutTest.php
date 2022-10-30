<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Controller\Observers\DataLayout;

final class DataLayoutTest extends TestCase {

  /**
   * 
   * @return void
   * 
   * @todo getDataLayout method should not be reliant a key called
   * layouts it needs to be refactored.
   */
  public function testDataAlterProd(): void {
    $obj = new DataLayout();
    $this->assertIsArray($obj->getDataLayout(['layouts' => []]));
  }

}
