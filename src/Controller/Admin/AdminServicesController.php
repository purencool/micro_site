<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\Processes\Install;
use App\Repository\Processes\Update;

class AdminServicesController extends AbstractController {

  /**
   * @inheritDoc
   */
  #[Route('/admin/processes', name: 'app_admin_layout')]
  public function index(): Response {
    Install::create();
    Update::update();
    return new Response('<html><body>Installed</body></html>');
  }

}
