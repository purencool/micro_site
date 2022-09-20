<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminLayoutViewController extends AbstractController
{
    #[Route('/admin/layout/view', name: 'app_admin_layout_view')]
    public function index(): Response
    {
        return $this->render('admin_layout_view/index.html.twig', [
            'title' => 'Available page layouts',
        ]);
    }
}
