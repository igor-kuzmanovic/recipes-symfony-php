<?php

namespace App\Transformer;

use App\Entity\Recipe;
use League\Fractal;

class RecipeToJsonTransformer extends Fractal\TransformerAbstract
{
    protected $availableIncludes = [
        'ingredients',
        'category',
        'tags'
    ];

    /**
     * @param Recipe $recipe
     * @return array
     */
    public function transform(Recipe $recipe)
    {
        return [
            'id' => (int) $recipe->getId(),
            'title' => $recipe->getTitle(),
            'description' => $recipe->getDescription(),
            'date' => $recipe->getDate()->format('Y-m-d H:i:s')
        ];
    }

    /**
     * @param Recipe $recipe
     * @return Fractal\Resource\Collection
     */
    public function includeIngredients(Recipe $recipe)
    {
        $ingredients = $recipe->getIngredients();

        return $this->collection($ingredients, new IngredientToJsonTransformer(), 'ingredients');
    }

    /**
     * @param Recipe $recipe
     * @return Fractal\Resource\Item
     */
    public function includeCategory(Recipe $recipe)
    {
        $category = $recipe->getCategory();

        return $this->item($category, new CategoryToJsonTransformer(), 'categories');
    }

    /**
     * @param Recipe $recipe
     * @return Fractal\Resource\Collection
     */
    public function includeTags(Recipe $recipe)
    {
        $tag = $recipe->getTags();

        return $this->collection($tag, new TagToJsonTransformer(), 'tags');
    }
}