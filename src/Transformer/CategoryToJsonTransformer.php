<?php

namespace App\Transformer;

use App\Entity\Category;
use League\Fractal;

class CategoryToJsonTransformer extends Fractal\TransformerAbstract
{
    /**
     * @param Category $category
     * @return array
     */
    public function transform(Category $category)
    {
        return [
            'id' => (int) $category->getId(),
            'name' => $category->getName(),
        ];
    }
}