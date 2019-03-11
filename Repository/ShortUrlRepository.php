<?php

namespace Beapp\UrlShortener\Repository;

use Beapp\UrlShortener\Entity\ShortUrlEntity;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;

class ShortUrlRepository extends EntityRepository
{
    /**
     * @param string $shortUrl
     *
     * @return ShortUrlEntity|null
     */
    public function findOneByUuid(string $shortUrl): ?ShortUrlEntity
    {
        $qb = $this->createQueryBuilder('su');

        $qb->where($qb->expr()->eq('su.shortUrl', ':shortUrl'))
            ->setParameter('shortUrl', $shortUrl);

        try{
            return $qb->getQuery()->getOneOrNullResult();
        }catch(NonUniqueResultException $e){
            return null;
        }
    }
}
