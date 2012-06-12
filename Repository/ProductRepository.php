<?php

namespace Garak\DemoBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ProductRepository
 *
 */
class ProductRepository extends EntityRepository
{
    /**
     * Search products by filters
     *
     * @param  array $filters
     * @return array
     */
    public function search(array $filters)
    {       
        $qb = $this->createQueryBuilder('p')
            ->select('p', 'c')
            ->leftJoin('p.category', 'c');
        if (!empty($filters['category'])) {
            $qb->andWhere('p.category = :cid')->setParameter('cid', $filters['category']);
        }
        if (!empty($filters['price'])) {
            $qb->andWhere('p.price = :p')->setParameter('p', $filters['price']);
        }
        if (!empty($filters['name'])) {
            $qb->andWhere($qb->expr()->like('p.name', ':n'))->setParameter('n', '%' . $filters['name'] . '%');
        }
            
        return $qb->getQuery()->getResult();
    }

    /**
     * Find products by its ids
     *
     * @param  array $ids
     * @return array      keys of array are ids themselves
     */
    public function findByIds(array $ids)
    {
        if (empty($ids)) {
            return array();
        }
        $qb = $this->createQueryBuilder('p');
        
        return $qb
            ->add('from', 'GarakDemoBundle:Product p INDEX BY p.id')
            ->where($qb->expr()->in('p.id', $ids))
            ->getQuery()
            ->getResult();
    }
}