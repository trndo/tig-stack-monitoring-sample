<?php

declare(strict_types=1);

namespace App\Controller;

use App\Document\Product;
use Doctrine\ODM\MongoDB\DocumentManager;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MongoLoadController extends AbstractController
{
    public function __construct(private DocumentManager $documentManager)
    {
    }

    #[Route('/products', methods: ['POST'])]
    public function load(Request $request): JsonResponse
    {
        $name = $request->request->get('name');
        $price = $request->request->get('price');

        $faker = Factory::create();

        $product = new Product($name.$faker->name, $price + $faker->randomFloat());
        $this->documentManager->persist($product);
        $this->documentManager->flush();

        $repository = $this->documentManager->getRepository(Product::class);
        $collection = $repository->createQueryBuilder()
            ->sort('id', 'DESC')
            ->limit(15)
            ->getQuery()->execute();

        $result = array_map(fn (Product $product) => $product->toArray(), $collection->toArray());

        return new JsonResponse($result);
    }
}