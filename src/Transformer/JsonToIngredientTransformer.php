<?php

namespace App\Transformer;

use App\Entity\Ingredient;

class JsonToIngredientTransformer extends JsonToObjectTransformer
{
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

    /**
     * @param string $content
     * @return Ingredient
     */
    public function transformSingle(string $content)
    {
        $ingredient = new Ingredient();

        $json = json_decode($content, true);
        $data = $this->getData($json);
        $this->transform($ingredient, $data);

        return $ingredient;
    }

    /**
     * @param string $content
     * @return array
     */
    public function transformMany(string $content)
    {
        $ingredients = [];

        $json = json_decode($content, true);
        $data = $this->getData($json);
        foreach ($data as $datum)
        {
            $ingredient = new Ingredient();
            $this->transform($ingredient, $datum);
            $ingredients[] = $ingredient;
        }

        return $ingredients;
    }
}