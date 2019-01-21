<?php

namespace App\Transformer;

use App\Entity\Tag;
use League\Fractal;

class TagToJsonTransformer extends Fractal\TransformerAbstract
{
    /**
     * @param Tag $tag
     *
     * @return array
     */
    public function transform(Tag $tag)
    {
        return [
            'id' => (int) $tag->getId(),
            'name' => $tag->getName(),
        ];
    }
}