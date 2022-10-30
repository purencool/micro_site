<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Controller\Observers\DataAlterProd;

final class DataAlterProdTest extends TestCase {

  /**
   * 
   * @return void
   */
  public function testDataAlterProd(): void {
    $obj = new DataAlterProd();
    $this->assertIsArray($obj->setChanges([]));
  }

}
