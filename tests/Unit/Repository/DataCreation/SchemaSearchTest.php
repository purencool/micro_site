<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Repository\DataCreation\SchemaSearch;

final class SchemaSearchTest extends TestCase {

  /**
   * @var array data set to be tested
   */
  private static function dataSet() {
    return json_decode('{
    "@types": {
        "default": {
            "header": {
                "@schema": "universal/header"
            },
            "content": {
                "@schema": "content/pages/article"
            },
            "footer": {
                "@schema": "universal/footer"
            }
        },
        "article": {
            "header": {
                "@schema": "universal/header"
            },
            "content": {
                "@schema": "content/articles/content/article"
            },
            "right_sidebar": {
                "@schema": "content/articles/sections/sidebar"
            },
            "footer": {
                "@schema": "universal/footer"
            }
        },
        "home": {
            "header": {
                "@schema": "universal/header"
            },
            "hero": {
                "@schema": "content/home/sections/hero"
            },
            "about": {
                "@schema": "content/home/sections/about"
            },
            "content": {
                "@schema": "content/home/home"
            },
            "articles": {
                "@schema": "content/home/home"
            },
            "footer": {
                "@schema": "universal/footer"
            }
        },
        "page": {
            "header": {
                "@schema": "universal/header"
            },
            "content": {
                "@schema": "content/pages/article"
            },
            "footer": {
                "@schema": "universal/footer"
            }
        }
    }
}
');
  }

  public function testPushAndPop(): void {
    $return = SchemaSearch::findSchemas(self::dataSet());
    $this->assertIsArray($return);
  }

}
