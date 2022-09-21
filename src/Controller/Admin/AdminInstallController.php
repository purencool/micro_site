<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\Twig\TwigExpressionEngine;

class AdminInstallController extends AbstractController
{

    /**
     * Copies default layouts from the config directory.
     * 
     * @param type $src
     *   Default source directory.
     * @param type $dst
     *   Default destination directory.
     */
    protected function recursiveCopy($src,$dst) 
    {
      $ds = DIRECTORY_SEPARATOR;
      $dir = opendir($src);
      @mkdir($dst);
      while(( $file = readdir($dir)) ) {
        if (( $file != '.' ) && ( $file != '..' )) {
          if ( \is_dir($src . $ds . $file) ) {
            $this->recursiveCopy($src . $ds . $file, $dst  .$ds . $file);
          } else  {
            copy($src . $ds . $file, $dst . $ds . $file);
          }
        }
      }
      closedir($dir);
    }

    /**
     * Installs Layouts.
     */
    protected function layouts()
    {
      $ds = DIRECTORY_SEPARATOR;
      $path = __DIR__ . $ds ."..". $ds ."..". $ds ."..". $ds;
      $this->recursiveCopy(
        $path . 'core'. $ds . 'layouts' . $ds,
        $path . 'templates'. $ds . 'layouts'
      );

      TwigExpressionEngine::create();
     
      $websiteConfigPath = $path . $ds ."..". $ds. 'website_configuration'. $ds . 'layouts' . $ds;
      if(is_dir($websiteConfigPath)){
        $this->recursiveCopy(
          $websiteConfigPath,
          $path . 'templates'. $ds . 'layouts'
        );
      }
    }

    /**
     * @inheritDoc
     */
    #[Route('/admin/install', name: 'app_admin_layout')]
    public function index(): Response
    {
      $this->layouts();
      return new Response('<html><body>Installed</body></html>');
    }
}
