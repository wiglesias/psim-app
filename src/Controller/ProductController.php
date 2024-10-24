<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\User;
use App\Repository\ProductRepository;
use App\Service\OrganizationAccessChecker;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/product')]
class ProductController extends AbstractController
{
    #[Route('', name: 'app_product', methods: ['POST'])]
    public function createProduct(
        Request $request,
        OrganizationAccessChecker $organizationAccessChecker,
        ProductRepository $productRepository): JsonResponse
    {
        $payload = $request->getPayload();
        $productName = $payload->get('name');

        /** @var User $user */
        $user = $this->getUser();

        $membership = $organizationAccessChecker->checkAccess($request, $user);
        $product = new Product($membership->getOrganization(), $productName);
        $productRepository->save($product);

        return new JsonResponse([
            'id' => $product->getId(),
        ]);
    }
}
