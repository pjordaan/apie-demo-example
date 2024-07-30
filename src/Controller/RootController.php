<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[Route('/')]
class RootController
{
    public function __invoke(UrlGeneratorInterface $urlGenerator): RedirectResponse
    {
        try {
            return new RedirectResponse($urlGenerator->generate('apie.collection.cms.dashboard'));
        } catch (RouteNotFoundException) {

            return new RedirectResponse($urlGenerator->generate('apie.collection.swagger_ui'));
        }
    }
}
