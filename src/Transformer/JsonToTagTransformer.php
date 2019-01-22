<?php

namespace App\Transformer;

use App\Entity\Tag;

class JsonToTagTransformer extends JsonToObjectTransformer
{
    /**
     * @param object &$object
     * @param array $relationships
     * @return void
     */
    protected function applyRelationships(object &$object, array $relationships)
    {
       $tag = $object;
    }

    /**
     * @param object &$object
     * @param array $attributes
     * @return void
     */
    protected function applyAttributes(object &$object, array $attributes)
    {
        $tag = $object;

        if (key_exists('name', $attributes))
        {
            $tag->setName($attributes['name']);
        }
    }

    /**
     * @param object &$object
     * @param int $id
     * @return void
     */
    protected function applyId(object &$object, int $id)
    {
        $tag = $object;

        if ($id > 0)
        {
            $tag->setId($id);
        }
    }

    /**
     * @param object &$object
     * @param array $data
     * @return void
     */
    protected function transform(object &$object, array $data)
    {
        $tag = $object;

        $id = $this->getId($data);
        $this->applyId($tag, $id);

        $type = $this->getType($data);

        $attributes = $this->getAttributes($data);
        $this->applyAttributes($tag, $attributes);
    }

    /**
     * @param string $content
     * @return Tag
     */
    public function transformSingle(string $content)
    {
        $tag = new Tag();

        $json = json_decode($content, true);
        $data = $this->getData($json);
        $this->transform($tag, $data);

        return $tag;
    }

    /**
     * @param string $content
     * @return array
     */
    public function transformMany(string $content)
    {
        $tags = [];

        $json = json_decode($content, true);
        $data = $this->getData($json);
        foreach ($data as $datum)
        {
            $tag = new Tag();
            $this->transform($tag, $datum);
            $tags[] = $tag;
        }

        return $tags;
    }
}