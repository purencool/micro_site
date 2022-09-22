<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\Processes\Install;
use App\Repository\Processes\Update;

class AdminStyleGuideController extends AbstractController {

  /**
   * @inheritDoc
   */
  #[Route('/admin/style-guide', name: 'app_admin_layout')]
  public function index(): Response {

    $request ="";
    $return = ['result' => 'Request is not valid'];

    switch ($request) {
      case 'install':
        $return = Install::create();
        break;

      case 'update':
        $return = Update::update();
        break;

      default:
        break;
    }

    return $this->render('core/admin_style_guide/index.html.twig', [
      'title' => 'Style Guide',
      'result' => $return['result'],
    ]);
  }

}
