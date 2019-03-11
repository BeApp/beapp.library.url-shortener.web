<?php

namespace Beapp\UrlShortener\Service;

use Beapp\UrlShortener\Entity\ShortUrlEntity;
use Beapp\UrlShortener\Exception\UrlShortenerException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\RouterInterface;

class UrlShortener
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var \Beapp\UrlShortener\Repository\ShortUrlRepository */
    private $shortUrlRepository;

    /** @var RouterInterface */
    private $router;

    /** @var string */
    private $shortUrlRoute;

    /**
     * UrlShortener constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param RouterInterface        $router
     * @param string                 $shortUrlRoute
     */
    public function __construct(EntityManagerInterface $entityManager, RouterInterface $router, string $shortUrlRoute)
    {
        $this->entityManager = $entityManager;
        $this->shortUrlRepository = $entityManager->getRepository(ShortUrlEntity::class);
        $this->router = $router;
        $this->shortUrlRoute = $shortUrlRoute;
    }

    /**
     * @param string $shortUrl
     *
     * @return ShortUrlEntity|null
     */
    public function findUrlFromShortened(string $shortUrl): ?ShortUrlEntity
    {
        return $this->shortUrlRepository->findOneByUuid($shortUrl);
    }

    /**
     * @param string $url
     *
     * @return string
     * @throws UrlShortenerException
     */
    public function shorten(string $url): string
    {
        $shortUrlEntity = new ShortUrlEntity($url, $this->generateShortUrl());

        $this->entityManager->persist($shortUrlEntity);
        $this->entityManager->flush();

        return $this->getShortUrlFromUuid($shortUrlEntity->getShortUrl());
    }

    /**
     * @param string $shortUrl
     *
     * @return string
     */
    public function getShortUrlFromUuid(string $shortUrl): string
    {
        return $this->router->generate($this->shortUrlRoute, ['shortUrl' => $shortUrl], UrlGenerator::ABSOLUTE_URL);
    }

    /**
     * @param int $length
     *
     * @return string
     */
    private function generateRandomString(int $length = 8): string
    {
        $seed = str_split('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
        $rand = '';
        foreach (array_rand($seed, $length) as $char) {
                $rand .= $seed[$char];
        }

        return  $rand;
    }

    /**
     * @return string
     * @throws UrlShortenerException
     */
    private function generateShortUrl(): string
    {
        for($i = 0; $i < 30; $i++){
            $shortUrl = $this->generateRandomString();

            if(!$this->urlHasCollision($shortUrl)){
                return $shortUrl;
            }
        }

        throw new UrlShortenerException();
    }

    /**
     * @param string $rand
     *
     * @return bool
     */
    private function urlHasCollision(string $rand)
    {
        $shortUrlEntity = $this->findUrlFromShortened($rand);

        return (null !== $shortUrlEntity);
    }
}
