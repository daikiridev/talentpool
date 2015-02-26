<?php

namespace TEW\TPBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * TaggingRepository
 *
 */
class TaggingRepository extends EntityRepository
{
    /**
     * Return all tags associated to candidates
     *
     */
    public function findAllCandidateTags($term = '') {
        $qb = $this->createQueryBuilder('tgg')
                //->select('t.id', 't.name' as 'label', 't.name' as value)
                ->select('t.id', 't.name as label','t.name')
                ->join('TEWTPBundle:Tag', 't')
                ->where("tgg.resourceType = :type")
                ->andWhere('tgg.tag = t.id')
                ->andWhere("t.name LIKE :term")
                ->distinct() // this could be avoided ?
                ->orderBy('t.name')
                ->setParameter('term', "%$term%")
                ->setParameter('type', 'candidate');
        $query = $qb->getQuery();
        return $query->getResult();
    }
}
