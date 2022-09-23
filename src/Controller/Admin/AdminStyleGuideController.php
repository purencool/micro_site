<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AdminStyleGuideController extends AbstractController {

  /**
   * @inheritDoc
   */
  #[Route('/admin/style-guide', name: 'app_admin_layout')]
  public function index(): Response {

    $return = ['result' => 'Request is not valid'];

    return $this->render('core/admin_style_guide/index.html.twig', [
      'title' => 'Style Guide',
      'result' => $return['result'],
    ]);
  }

}
