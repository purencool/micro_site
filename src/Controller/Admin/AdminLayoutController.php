<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminLayoutController extends AbstractController
{
    #[Route('/admin/layout', name: 'app_admin_layout')]
    public function index(): Response
    {
      $ds = DIRECTORY_SEPARATOR;
      $directoryPath = __DIR__ . $ds ."..". $ds ."..". $ds ."..". $ds;
      $directoryArr = scandir($directoryPath.$ds. "templates");
      $findDirectory = array_search('default_layouts',$directoryArr);

      
      if($findDirectory !== true){
        $from = $directoryPath . 'config'. $ds . 'default_layouts';
        $to = $directoryPath . 'templates'. $ds . 'default_layouts';
        $files = array_filter(glob("$from*"), "is_file");
        foreach ($files as $f) { copy($f, $to . basename($f)); }
        return new Response('<html><body>Not installed</body></html>');
      }
      return new Response('<html><body>Already installed</body></html>');
    }
}
