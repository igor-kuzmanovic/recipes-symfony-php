<?php

namespace App\Transformer;

use App\Entity\Category;

class JsonToCategoryTransformer extends JsonToObjectTransformer
{
    /**
     * @param array $data
     *
     * @return Category
     */
    protected function transform(array $data)
    {
        $category = new Category();

        $id = $this->getId($data);
        if ($id > 0)
        {
            $category->setId($id);
        }

        $type = $this->getType($data);

        $attributes = $this->getAttributes($data);
        if (key_exists('name', $attributes))
        {
            $category->setName($attributes['name']);
        }

        return $category;
    }

    /**
     * @param string $content
     *
     * @return Category
     */
    public function transformSingle(string $content)
    {
        $category = new Category();

        $json = json_decode($content, true);
        $data = $this->getData($json);
        $category = $this->transform($data);

        return $category;
    }

    /**
     * @param string $content
     *
     * @return array
     */
    public function transformMany(string $content)
    {
        $categories = [];

        $json = json_decode($content, true);
        $data = $this->getData($json);
        foreach ($data as $datum)
        {
            $categories[] = $this->transform($datum);
        }

        return $categories;
    }
}