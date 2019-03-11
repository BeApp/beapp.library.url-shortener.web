<?php

namespace Beapp\UrlShortener\Controller;

use Beapp\UrlShortener\Service\UrlShortener;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ShortUrlController extends AbstractController
{
    /**
     * @Route("/s/{shortUrl}", name="app_shortened_url", methods={"GET"})
     *
     * @param string       $shortUrl
     * @param UrlShortener $urlShortener
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function getUrlFromShortened(string $shortUrl, UrlShortener $urlShortener)
    {
        $shortUrlEntity = $urlShortener->findUrlFromShortened($shortUrl);

        if(null === $shortUrlEntity){
            return $this->createNotFoundException();
        }

        return $this->redirect($shortUrlEntity->getFullUrl());
    }
}
