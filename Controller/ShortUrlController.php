<?php

namespace Beapp\UrlShortener\Controller;

use Beapp\UrlShortener\Service\UrlShortener;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ShortUrlController extends AbstractController
{
    /**
     * @Route("/%beapp-url-shortener.route_prefix%/{shortUrl}", name="beapp_shortened_url", methods={"GET"})
     *
     * @param string       $shortUrl
     * @param UrlShortener $urlShortener
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function getUrlFromShortened(string $shortUrl, UrlShortener $urlShortener)
    {
        $shortUrlEntity = $urlShortener->findUrlFromShortened($shortUrl);

        if(null === $shortUrlEntity){
            throw $this->createNotFoundException();
        }

        return $this->redirect($shortUrlEntity->getFullUrl());
    }
}
