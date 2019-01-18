<?php

namespace App\Transformer;

use App\Entity\Tag;
use League\Fractal;

class TagTransformer extends Fractal\TransformerAbstract
{
    public function transform(Tag $tag)
    {
        return [
            'id' => (int) $tag->getId(),
            'name' => $tag->getName()
        ];
    }
}