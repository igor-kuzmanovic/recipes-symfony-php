<?php

namespace App\Transformer;

use App\Entity\Category;
use App\Entity\Ingredient;
use App\Entity\Recipe;
use App\Entity\Tag;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;

class JsonToRecipeTransformer extends JsonToObjectTransformer
{
    public function __construct(EntityManagerInterface $em = null)
    {
        parent::__construct($em);

        $this->className = Recipe::class;
    }

    /**
     * @param object &$object
     * @param array $relationships
     * @return void
     */
    protected function applyRelationships(object &$object, array $relationships)
    {
        $recipe = $object;

        if (key_exists('ingredients', $relationships))
        {
            $recipe->setIngredients(new ArrayCollection());

            $ingredientsRelationship = $relationships['ingredients'];
            $ingredientsData = $this->getData($ingredientsRelationship);

            $ids = $this->getIds($ingredientsData);

            foreach ($ids as $id)
            {
                $ingredient = $this->em->getRepository(Ingredient::class)->find($id);

                if (!$recipe->getIngredients()->contains($ingredient))
                {
                    $recipe->getIngredients()->add($ingredient);
                }
            }
        }

        if (key_exists('category', $relationships))
        {
            $categoryRelationship = $relationships['category'];
            $categoryData = $this->getData($categoryRelationship);
            $id = $this->getId($categoryData);

            $category = $this->em->getRepository(Category::class)->find($id);
            $recipe->setCategory($category);
        }

        if (key_exists('tags', $relationships))
        {
            $recipe->setTags(new ArrayCollection());

            $tagsRelationship = $relationships['tags'];
            $tagsData = $this->getData($tagsRelationship);

            $ids = $this->getIds($tagsData);

            foreach ($ids as $id)
            {
                $tag = $this->em->getRepository(Tag::class)->find($id);
                if (!$recipe->getTags()->contains($tag))
                {
                    $recipe->getTags()->add($tag);
                }
            }
        }
    }

    /**
     * @param object &$object
     * @param array $attributes
     * @return void
     */
    protected function applyAttributes(object &$object, array $attributes)
    {
        $recipe = $object;

        if (key_exists('title', $attributes))
        {
            $recipe->setTitle($attributes['title']);
        }

        if (key_exists('description', $attributes))
        {
            $recipe->setDescription($attributes['description']);
        }

        if (key_exists('date', $attributes))
        {
            $recipe->setDate($attributes['date']);
        }

        if (key_exists('image-url', $attributes))
        {
            $recipe->setImageUrl($attributes['image-url']);
        }
    }

    /**
     * @param object &$object
     * @param int $id
     * @return void
     */
    protected function applyId(object &$object, int $id)
    {
        $recipe = $object;

        if ($id > 0)
        {
            $recipe->setId($id);
        }
    }
    
    /**
     * @param object &$object
     * @param array $data
     * @return void
     */
    protected function transform(object &$object, array $data)
    {
        $recipe = $object;

        $id = $this->getId($data);
        $this->applyid($recipe, $id);

        $type = $this->getType($data);

        $attributes = $this->getAttributes($data);
        $this->applyAttributes($recipe, $attributes);

        $relationships = $this->getRelationships($data);
        $this->applyRelationships($recipe, $relationships);
    }
}