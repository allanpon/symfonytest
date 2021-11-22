<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index()
    {
        return $this->render('home/index.html.twig');
    }

    #[Route('/test/{nom?}', name: 'test')]
    public function test(Request $request)
    {
        $nom = $request->get('nom');
        return $this->render('home/test.html.twig', [
            'nom' => $nom
        ]);
    }
}
