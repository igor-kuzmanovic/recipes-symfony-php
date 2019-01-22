<?php

namespace App\Repository;

use App\Entity\Recipe;
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
     *
     */
    public function findByFilter(array $filter)
    {
        $recipes = [];

        $qb = $this->createQueryBuilder('r');
        $qb->select(array('r'))
            ->from('Recipe', 'r');

        if (key_exists('date', $filter))
        {
            $date = $filter['date'];
        }

        if (key_exists('category', $filter))
        {
            $categories = $filter['category'];
        }

        if (key_exists('tag', $filter))
        {
            $tags = $filter['tag'];
        }

        return $recipes;
    }
}