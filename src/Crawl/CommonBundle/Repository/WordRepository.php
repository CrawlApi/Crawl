<?php

namespace Crawl\CommonBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * WordRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class WordRepository extends EntityRepository
{
    public function findByWord($word)
    {
        $result = $this->createQueryBuilder('q')
            ->select('q, c')
            ->leftJoin('q.WordCollins', 'c')
            ->where('q.word = :word')
            ->setParameter('word', $word)
            ->getQuery()
            ->getArrayResult();

        return count($result) ? $result[0] : null;
    }
}
