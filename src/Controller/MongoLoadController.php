<?php

declare(strict_types=1);

namespace App\Controller;

use MongoDB\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class MongoLoadController extends AbstractController
{
    #[Route('/mongo/load', methods: ['GET'])]
    public function load(): JsonResponse
    {
        $mongo = new Client('mongodb://root:pass@mongo:27017');

        $collection = $mongo->selectDatabase('test')->selectCollection('users');

        $result = $collection->insertOne([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'name' => 'Admin User',
        ]);

        return new JsonResponse(
            [
                'InsertedId' => $result->getInsertedId(),
                'InsertedCount' => $result->getInsertedCount(),
            ]
        );
    }
}