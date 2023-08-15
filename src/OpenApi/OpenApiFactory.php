<?php

namespace App\OpenApi;

use ApiPlatform\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\OpenApi\Model\PathItem;
use ApiPlatform\OpenApi\OpenApi;

class OpenApiFactory implements OpenApiFactoryInterface
{

    public function __construct( private readonly OpenApiFactoryInterface $decorated)
    {

    }

    public function __invoke(array $context = []): OpenApi
    {
        $openApi = $this->decorated->__invoke($context);
        /**
         * @var PathItem $path
         */
        foreach ($openApi->getPaths()->getPaths() as $path => $item) {
            if ($item->getGet() && $item->getGet()->getSummary() === 'Count properties') {

            }
        }
        return $openApi;
    }
}