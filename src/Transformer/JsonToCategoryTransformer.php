<?php

namespace App\Transformer;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;

class JsonToCategoryTransformer extends JsonToObjectTransformer
{
    public function __construct(EntityManagerInterface $em = null)
    {
        parent::__construct($em);

        $this->className = Category::class;
    }

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
}