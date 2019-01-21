<?php

namespace App\Transformer;

use App\Entity\Tag;

class JsonToTagTransformer extends JsonToObjectTransformer
{
    /**
     * @param array $data
     *
     * @return Tag
     */
    protected function transform(array $data)
    {
        $tag = new Tag();

        $id = $this->getId($data);
        if ($id > 0)
        {
            $tag->setId($id);
        }

        $type = $this->getType($data);

        $attributes = $this->getAttributes($data);
        if (key_exists('name', $attributes))
        {
            $tag->setName($attributes['name']);
        }

        return $tag;
    }

    /**
     * @param string $content
     *
     * @return Tag
     */
    public function transformSingle(string $content)
    {
        $tag = new Tag();

        $json = json_decode($content, true);
        $data = $this->getData($json);
        $tag = $this->transform($data);

        return $tag;
    }

    /**
     * @param string $content
     *
     * @return array
     */
    public function transformMany(string $content)
    {
        $tags = [];

        $json = json_decode($content, true);
        $data = $this->getData($json);
        foreach ($data as $datum)
        {
            $tags[] = $this->transform($datum);
        }

        return $tags;
    }
}