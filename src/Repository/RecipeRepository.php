<?php

namespace App\Repository;

use App\Entity\Recipe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class RecipeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Recipe::class);
    }

    /**
     * @param array $filter
     * @return array
     */
    public function findByFilter(array $filter)
    {
        $qb = $this->createQueryBuilder('r')
            ->addSelect('i, t')
            ->join('r.ingredients', 'i')
            ->join('r.tags', 't')
            ->join('r.tags', 't1');

        if (key_exists('dateFrom', $filter) && key_exists('dateTo', $filter))
        {
            $dateFrom = $filter['dateFrom'];
            $dateTo = $filter['dateTo'];

            $qb->orWhere('r.date BETWEEN :dateFrom AND :dateTo')
                ->setParameter('dateFrom', $dateFrom)
                ->setParameter('dateTo', $dateTo);
        }
        else
        {
            if (key_exists('dateFrom', $filter))
            {
                $dateFrom = $filter['dateFrom'];

                $qb->orWhere('r.date >= :dateFrom')
                    ->setParameter('dateFrom', $dateFrom);
            }

            if (key_exists('dateTo', $filter))
            {
                $dateTo = $filter['dateTo'];

                $qb->orWhere('r.date <= :dateTo')
                    ->setParameter('dateTo', $dateTo);
            }
        }

        if (key_exists('category', $filter))
        {
            $categories = explode(',', $filter['category']);

            $qb->orWhere('r.category IN (:categories)')
                ->setParameter('categories', $categories);
        }

        if (key_exists('tag', $filter))
        {
            $tags = explode(',', $filter['tag']);

            $qb->orWhere('t1 IN (:tags)')
                ->setParameter('tags', $tags);
        }

        return $qb->getQuery()->getResult();
    }
}
