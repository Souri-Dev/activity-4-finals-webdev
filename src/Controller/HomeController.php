<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request, Connection $connection): Response
    {
        $projectDir = $this->getParameter('kernel.project_dir');

        // 1. Check Database and Entities
        $dbConnected = false;
        $userTableExists = false;
        $ticketTableExists = false;
        $dbError = null;

        try {
            // Force an actual DB connection/query before reporting PASS.
            $connection->executeQuery('SELECT 1');

            $schemaManager = $connection->createSchemaManager();
            $dbConnected = true;

            // Pass the table name as a single-element array to avoid deprecations
            $userTableExists = $schemaManager->tablesExist(['user']);
            $ticketTableExists = $schemaManager->tablesExist(['ticket']);
        } catch (\Throwable $e) {
            // Keep a short error message for diagnostics.
            $dbError = $e->getMessage();
        }

        // 2. Check Web CRUD (Did they run make:crud Ticket?)
        $crudExists = file_exists($projectDir . '/src/Controller/TicketController.php');

        // 3. Check JWT Keys (Did they run the Lexik generate keys command?)
        $jwtKeysExist = file_exists($projectDir . '/config/jwt/private.pem');

        // Intentionally passing 'user_name' to trigger the Milestone 0 Twig bug
        return $this->render('home/index.html.twig', [
            'user_name' => 'Examinee',
            'client_ip' => $request->getClientIp(),
            'db_connected' => $dbConnected,
            'db_error' => $dbError,
            'user_table' => $userTableExists,
            'ticket_table' => $ticketTableExists,
            'crud_exists' => $crudExists,
            'jwt_keys' => $jwtKeysExist,
        ]);
    }
}
