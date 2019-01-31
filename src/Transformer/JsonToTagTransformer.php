<?php

namespace App\Transformer;

use App\Entity\Tag;
use Doctrine\ORM\EntityManagerInterface;

class JsonToTagTransformer extends JsonToObjectTransformer
{
    public function __construct(EntityManagerInterface $em = null)
    {
        parent::__construct($em);

        $this->className = Tag::class;
    }

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
            $name = $attributes['name'];

            if (is_null($name))
            {
                $name = '';
            }

            $tag->setName($name);
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
}