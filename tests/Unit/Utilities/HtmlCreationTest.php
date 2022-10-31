<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Controller\Observers\HtmlCreation;

final class HtmlCreationTest extends TestCase {

  /**
   * 
   * @return void
   * @todo getDataLayout method should not be reliant a key called
   * layout_data_combined it needs to be refactored.
   */
  public function testHtmlCreation(): void {
    $obj = new HtmlCreation();
    $this->assertIsString($obj->setChanges(['layout_data_combined' => []]));
  }

}
