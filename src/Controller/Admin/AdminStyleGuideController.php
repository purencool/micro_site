<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AdminStyleGuideController extends AbstractController {

  /**
   * 
   */
  protected $styleGuide = [
    'header' => [
      'branding' => [],
      'navigation' => []
    ],
    'navigation' => [],
    'branding_commication' => [],
    'communication' => [
      'global_communication' => [],
      'site_communication' => [],
    ],
    'introduction' => [],
    'content' => [
      'right_side' => [],
      'middle' => [],
      'right_side' => [],
    ],

    'footer' => [
      'section_one' => [],
      'section_two' => [],
      'general_communication' => [],
    ], 
  ];

  /**
   * @inheritDoc
   */
  #[Route('/admin/style-guide', name: 'app_admin_layout')]
  public function index(): Response {

    if($this->getParameter('app.style_guide') != true){
      return new Response('Access denied');
    } 
 
    $return = ['result' => 'Request is not valid'];

    $path = 'layouts/one_column/templates';
    return $this->render($path.'/index.html.twig', [
      'title' => 'Style Guide',
      'result' => $return['result'],
    ]);
  }

}
