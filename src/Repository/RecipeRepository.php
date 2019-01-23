<?php

namespace App\Repository;

use App\Entity\Recipe;
use App\Entity\Tag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Validator\Constraints\DateTime;

class RecipeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Recipe::class);
    }

    /**
     * @param array $filter
     * @return array
     *
     * example: 'http://localhost:8000/api/recipes?filter[date]=2019-01-01&filter[category]=1,3,5&filter[tag]=2,4'
     */
    public function findByFilter(array $filter)
    {
        $qb = $this->createQueryBuilder('r')
            ->addSelect('i, t')
            ->join('r.ingredients', 'i')
            ->join('r.tags', 't1')
            ->join('r.tags', 't');

        if (key_exists('date', $filter))
        {
            $date = $filter['date'];

            $qb->orWhere('r.date >= :date')
                ->setParameter('date', $date);
        }

        if (key_exists('category', $filter))
        {
            $categories = explode(',', $filter['category']);

            $qb->orWhere('r.category IN (:categories)')
                ->setParameter('categories', $categories);
        }

        if (key_exists('tags', $filter))
        {
            $tags = explode(',', $filter['tags']);

            $qb->orWhere('t1 IN (:tags)')
                ->setParameter('tags', $tags);
        }

        return $qb->getQuery()->getResult();
    }
}