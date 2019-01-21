<?php

namespace App\Transformer;

use App\Entity\Recipe;

class JsonToRecipeTransformer extends JsonToObjectTransformer
{
    /**
     * @param array $data
     *
     * @return Recipe
     */
    protected function transform(array $data)
    {
        $recipe = new Recipe();

        $id = $this->getId($data);
        if ($id > 0)
        {
            $recipe->setId($id);
        }

        $type = $this->getType($data);

        $attributes = $this->getAttributes($data);
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

        $relationships = $this->getRelationships($data);
        if (key_exists('ingredients', $relationships))
        {
            $transformer = new JsonToIngredientTransformer();
            $recipe->setIngredients($transformer->transformMany($relationships['ingredients']));
        }
        if (key_exists('category', $relationships))
        {
            $transformer = new JsonToCategoryTransformer();
            $recipe->setCategory($transformer->transformSingle($relationships['category']));
        }
        if (key_exists('tags', $relationships))
        {
            $transformer = new JsonToTagTransformer();
            $recipe->setTags($transformer->transformMany($relationships['tags']));
        }

        return $recipe;
    }

    /**
     * @param string $content
     *
     * @return Recipe
     */
    public function transformSingle(string $content)
    {
        $recipe = new Recipe();

        $json = json_decode($content, true);
        $data = $this->getData($json);
        $recipe = $this->transform($data);

        return $recipe;
    }

    /**
     * @param string $content
     *
     * @return array
     */
    public function transformMany(string $content)
    {
        $recipes = [];

        $json = json_decode($content, true);
        $data = $this->getData($json);
        foreach ($data as $datum)
        {
            $recipes[] = $this->transform($datum);
        }

        return $recipes;
    }
}