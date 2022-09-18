<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ClienteController extends AbstractController
{
    #[Route('/cliente', name: 'app_cliente')]
    public function index(Request $request): Response
    {
        // var_dump(
        //     $request->query->all()
        // );

        var_dump(
            $request->get('cor')
        );

        return $this->render('cliente/index.html.twig', [
            'controller_name' => 'ClienteController',
        ]);
    }
}
