<?php

namespace App\Transformer;

use App\Entity\Ingredient;
use Doctrine\ORM\EntityManagerInterface;

class JsonToIngredientTransformer extends JsonToObjectTransformer
{
    public function __construct(EntityManagerInterface $em = null)
    {
        parent::__construct($em);

        $this->className = Ingredient::class;
    }

    /**
     * @param object $object
     * @param array $relationships
     * @return void
     */
    protected function applyRelationships(object &$object, array $relationships)
    {
        $ingredient = $object;
    }

    /**
     * @param object $object
     * @param array $attributes
     * @return void
     */
    protected function applyAttributes(object &$object, array $attributes)
    {
        $ingredient = $object;

        if (key_exists('name', $attributes))
        {
            $ingredient->setName($attributes['name']);
        }
    }

    /**
     * @param object $object
     * @param int $id
     * @return void
     */
    protected function applyId(object &$object, int $id)
    {
        $ingredient = $object;

        if ($id > 0)
        {
            $ingredient->setId($id);
        }
    }

    /**
     * @param object &$object
     * @param array $data
     * @return void
     */
    protected function transform(object &$object, array $data)
    {
        $ingredient = $object;

        $id = $this->getId($data);
        $this->applyId($ingredient, $id);

        $type = $this->getType($data);

        $attributes = $this->getAttributes($data);
        $this->applyAttributes($ingredient, $attributes);
    }
}