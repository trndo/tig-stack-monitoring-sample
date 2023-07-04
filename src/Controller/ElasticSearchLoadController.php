<?php

declare(strict_types=1);

namespace App\Controller;

use Elastic\Elasticsearch\ClientBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ElasticSearchLoadController extends AbstractController
{
    #[Route('/elasticsearch/load', methods: ['GET'])]
    public function load(): JsonResponse
    {
        $elastic = ClientBuilder::create()->setHosts(['elasticsearch:9200'])->build();

        $elastic->index(
            [
                'index' => 'users',
                'body' => [
                    'username' => 'admin',
                    'email' => 'admin@example.com',
                    'name' => 'Admin User',
                ]
            ]
        );

        $result = $elastic->search(
            [
                'index' => 'users',
                'body'  => [
                    'query' => [
                        'match' => [
                            'username' => 'admin'
                        ]
                    ]
                ]
            ]
        )->asArray();

        return new JsonResponse($result);
    }
}