<?php

namespace App\Transformer;

use App\Entity\Ingredient;

class JsonToIngredientTransformer extends JsonToObjectTransformer
{
    /**
     * @param array $data
     *
     * @return Ingredient
     */
    protected function transform(array $data)
    {
        $ingredient = new Ingredient();

        $id = $this->getId($data);
        if ($id > 0)
        {
            $ingredient->setId($id);
        }

        $type = $this->getType($data);

        $attributes = $this->getAttributes($data);
        if (key_exists('name', $attributes))
        {
            $ingredient->setName($attributes['name']);
        }

        return $ingredient;
    }

    /**
     * @param string $content
     *
     * @return Ingredient
     */
    public function transformSingle(string $content)
    {
        $ingredient = new Ingredient();

        $json = json_decode($content, true);
        $data = $this->getData($json);
        $ingredient = $this->transform($data);

        return $ingredient;
    }

    /**
     * @param string $content
     *
     * @return array
     */
    public function transformMany(string $content)
    {
        $ingredients = [];

        $json = json_decode($content, true);
        $data = $this->getData($json);
        foreach ($data as $datum)
        {
            $ingredients[] = $this->transform($datum);
        }

        return $ingredients;
    }
}