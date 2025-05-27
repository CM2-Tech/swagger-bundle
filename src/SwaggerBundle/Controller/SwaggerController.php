<?php

namespace CM2\SwaggerBundle\Controller;

use OpenApi\Generator;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SwaggerController
{
    #[Route('/_swagger', name: 'swagger_json')]
    public function __invoke(Request $request): JsonResponse
    {
        $token = $request->query->get('token');
        $expectedToken = $_ENV['SWAGGER_TOKEN'] ?? getenv('SWAGGER_TOKEN');

        if ($token !== $expectedToken) {
            return new JsonResponse(['error' => 'Access denied'], 403);
        }

        $sources = [__DIR__.'/../../../src/Controller', __DIR__.'/../../../src/Entity'];
        $openapi = Generator::scan($sources);

        return new JsonResponse(json_decode($openapi->toJson(), true));
    }
}
