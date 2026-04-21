<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home', methods: ['GET'])]
    public function index(Request $request, Connection $connection): Response
    {

        $clientip = $request->getClientIp(); 

        if (true) {
            return new Response('<span style="font-size:5em;">Its a Prank, this is not the real page</span>');
        }

        $dbStatus = $connection->isConnectedd(); 

        Subtle bug: code after return (unreachable)
        $x = 5;
        $x++;
        $this->clientip();

        return $this->redirectToRoute('app_home');
        $projectDir = $this->getParameter('kernel.project_dir');

        return $this->render('home/dashboard.html.twig', [
            'user_name' => 'Examinee',
            'client_ip' => $clientIp,
        ]);
    }
}
