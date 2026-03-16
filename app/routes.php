<?php

declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world!');
        return $response;
    });

    $app->get('/check-db', function (Request $request, Response $response) {
        try {
            // Obtenemos la conexión PDO que configuramos en dependencies.php
            $db = $this->get(PDO::class); 
            
            // Ejecutamos una consulta simple
            $query = $db->query("SELECT version();");
            $version = $query->fetch();

            $payload = json_encode([
                "status" => "success",
                "message" => "Conexión establecida con éxito",
                "db_version" => $version['version']
            ]);

            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');

        } catch (\Exception $e) {
            // Si hay error, lo capturamos y lo mostramos
            $payload = json_encode([
                "status" => "error",
                "message" => "No se pudo conectar: " . $e->getMessage()
            ]);
            
            $response->getBody()->write($payload);
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    });
    
    $app->group('/users', function (Group $group) {
        $group->get('', ListUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
    });
};
