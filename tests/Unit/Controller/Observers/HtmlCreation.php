<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Controller\Observers\HtmlCreation;

final class HtmlCreation extends TestCase {

  /**
   * 
   * @return void
   */
  public function testDataAlterProd(): void {
    $obj = new HtmlCreation();
    $this->assertIsArray($obj->setChanges([]));
  }

}
