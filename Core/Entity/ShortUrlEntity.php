<?php

namespace Beapp\UrlShortener\Entity;

use Beapp\Doctrine\Extension\Entity\DateTrait;
use Beapp\Doctrine\Extension\Entity\IdTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class ShortUrlEntity
 * @package App\Entity
 * @ORM\Table(name="short_url")
 * @ORM\Entity(repositoryClass="Beapp\UrlShortener\Repository\ShortUrlRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class ShortUrlEntity
{
    use IdTrait;
    use DateTrait;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=8, unique=true)
     */
    private $shortUrl;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    private $fullUrl;

    /**
     * ShortUrlEntity constructor.
     *
     * @param string $fullUrl
     * @param string $shortUrl
     */
    public function __construct(string $fullUrl, string $shortUrl)
    {
        $this->fullUrl = $fullUrl;
        $this->shortUrl = $shortUrl;
    }

    /**
     * @param string $shortUrl
     *
     * @return ShortUrlEntity
     */
    public function setShortUrl(string $shortUrl): ShortUrlEntity
    {
        $this->shortUrl = $shortUrl;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getShortUrl(): ?string
    {
        return $this->shortUrl;
    }

    /**
     * @param string $fullUrl
     *
     * @return ShortUrlEntity
     */
    public function setFullUrl(string $fullUrl): ShortUrlEntity
    {
        $this->fullUrl = $fullUrl;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFullUrl(): ?string
    {
        return $this->fullUrl;
    }

}
