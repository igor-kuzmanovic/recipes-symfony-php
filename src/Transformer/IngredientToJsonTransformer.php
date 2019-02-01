<?php

namespace App\Transformer;

use App\Entity\Ingredient;
use League\Fractal;

class IngredientToJsonTransformer extends Fractal\TransformerAbstract
{
    /**
     * @param Ingredient $ingredient
     * @return array
     */
    public function transform(Ingredient $ingredient)
    {
        return [
            'id' => (int) $ingredient->getId(),
            'name' => $ingredient->getName(),
        ];
    }
}