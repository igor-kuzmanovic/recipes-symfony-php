<?php

namespace App\Transformer;

use App\Entity\Category;

class JsonToCategoryTransformer extends JsonToObjectTransformer
{
    /**
     * @param object $object
     * @param array $relationships
     * @return void
     */
    protected function applyRelationships(object &$object, array $relationships)
    {
        $category = $object;
    }

    /**
     * @param object $object
     * @param array $attributes
     * @return void
     */
    protected function applyAttributes(object &$object, array $attributes)
    {
        $category = $object;

        if (key_exists('name', $attributes))
        {
            $category->setName($attributes['name']);
        }
    }

    /**
     * @param object $object
     * @param int $id
     * @return void
     */
    protected function applyId(object &$object, int $id)
    {
        $category = $object;

        if ($id > 0)
        {
            $category->setId($id);
        }
    }

    /**
     * @param object &$object
     * @param array $data
     * @return void
     */
    protected function transform(object &$object, array $data)
    {
        $category = $object;

        $id = $this->getId($data);
        $this->applyId($category, $id);

        $type = $this->getType($data);

        $attributes = $this->getAttributes($data);
        $this->applyAttributes($category, $attributes);
    }

    /**
     * @param string $content
     * @return Category
     */
    public function transformSingle(string $content)
    {
        $category = new Category();

        $json = json_decode($content, true);
        $data = $this->getData($json);
        $this->transform($category,$data);

        return $category;
    }

    /**
     * @param string $content
     * @return array
     */
    public function transformMany(string $content)
    {
        $categories = [];

        $json = json_decode($content, true);
        $data = $this->getData($json);
        foreach ($data as $datum)
        {
            $category = new Tag();
            $this->transform($category, $datum);
            $categories[] = $category;
        }

        return $categories;
    }
}