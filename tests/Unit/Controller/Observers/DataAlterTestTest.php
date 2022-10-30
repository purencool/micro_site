<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Controller\Observers\DataAlterTest;

final class DataAlterTestTest extends TestCase {

  /**
   * 
   * @return void
   */
  public function testDataAlterProd(): void {
    $obj = new DataAlterTest();
    $this->assertIsArray($obj->setChanges([]));
  }

}
