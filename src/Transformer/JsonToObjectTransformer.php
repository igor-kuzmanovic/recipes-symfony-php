<?php

namespace App\Transformer;

use App\Entity\Tag;

abstract class JsonToObjectTransformer
{
    /**
     * @param array $data
     *
     * @return mixed
     */
    abstract protected function transform(array $data);

    /**
     * @param string $content
     *
     * @return mixed
     */
    abstract public function transformSingle(string $content);

    /**
     * @param string $content
     *
     * @return array
     */
    abstract public function transformMany(string $content);

    /**
     * @param array $json
     *
     * @return array
     */
    protected function getData(array $json)
    {
        $data = [];

        if(key_exists('data', $json))
        {
            $data = $json['data'];
        }

        return $data;
    }

    /**
     * @param array $data
     *
     * @return int
     */
    protected function getId(array $data)
    {
        $id = 0;

        if(key_exists('id', $data))
        {
            $id = $data['id'];
        }

        return $id;
    }

    /**
     * @param array $data
     *
     * @return string
     */
    protected function getType(array $data)
    {
        $type = '';

        if(key_exists('type', $data))
        {
            $type .= $data['type'];
        }

        return $type;
    }

    /**
     * @param array $data
     *
     * @return array
     */
    protected function getAttributes(array $data)
    {
        $attributes = [];

        if(key_exists('attributes', $data))
        {
            $attributes = $data['attributes'];
        }

        return $attributes;
    }

    /**
     * @param array $data
     *
     * @return array
     */
    protected function getRelationships(array $data)
    {
        $relationships = [];

        if(key_exists('relationships', $data))
        {
            $relationships = $data['relationships'];
        }

        return $relationships;
    }
}