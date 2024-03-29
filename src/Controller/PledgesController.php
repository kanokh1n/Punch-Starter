<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PledgesController extends AbstractController
{
    #[Route('/pledges', name: 'app_pledges')]
    public function index(): Response
    {
        return $this->render('pledges/index.html.twig', [
            'controller_name' => 'PledgesController',
        ]);
    }
}
