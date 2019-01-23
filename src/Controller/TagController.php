<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Transformer\ErrorToJsonTransformer;
use App\Transformer\JsonToTagTransformer;
use App\Transformer\TagToJsonTransformer;
use Doctrine\ORM\EntityManagerInterface;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;
use League\Fractal\Serializer\JsonApiSerializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/api/tags")
 */
class TagController extends AbstractController
{
    private $type = 'tags';
    private $apiUrl = 'http://localhost:8000/api';
    private $baseUrl = 'http://localhost:8000/api/tags/';

    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param ValidatorInterface $validator
     * @return Response
     *
     * @Route("", methods={"POST"}, name="tag_create")
     */
    public function create(Request $request, EntityManagerInterface $em, ValidatorInterface $validator) : Response
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/vnd.api+json');

        $content = $request->getContent();
        $transformer = new JsonToTagTransformer();
        $tag = $transformer->transformSingle($content);

        if ($tag)
        {
            $errors = $validator->validate($tag);

            if (count($errors) == 0)
            {
                $em->persist($tag);
                $em->flush();
                $resource = new Item($tag, new TagToJsonTransformer(), $this->type);

                $manager = new Manager();
                $manager->setSerializer(new JsonApiSerializer($this->apiUrl));
                $content = $manager->createData($resource)->toJson();

                $response->setContent($content);
                $response->headers->set('Location', $this->baseUrl.'/'.$tag->getId());
                $response->setStatusCode(Response::HTTP_CREATED);
            }
            else
            {
                $transformer = new ErrorToJsonTransformer();
                $errorMessage = $transformer->transform($errors);
                $response->setContent($errorMessage);
                $response->setStatusCode(Response::HTTP_BAD_REQUEST);
            }
        }
        else
        {
            $response->setStatusCode(Response::HTTP_FORBIDDEN);
        }

        return $response;
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     *
     * @Route("", methods={"GET"}, name="tag_read_all")
     */
    public function readAll(Request $request, EntityManagerInterface $em) : Response
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/vnd.api+json');

        $tags = $em->getRepository(tag::Class)->findAll();
        $resource = new Collection($tags, new TagToJsonTransformer(), $this->type);

        $manager = new Manager();
        $manager->setSerializer(new JsonApiSerializer($this->apiUrl));
        $content = $manager->createData($resource)->toJson();

        $response->setContent($content);
        $response->setStatusCode(Response::HTTP_OK);

        return $response;
    }

    /**
     * @param int $id
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     *
     * @Route("/{id}", methods={"GET"}, name="tag_read")
     */
    public function read(int $id, Request $request, EntityManagerInterface $em) : Response
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/vnd.api+json');

        $tag = $em->getRepository(Tag::Class)->find($id);

        if ($tag)
        {
            $resource = new Item($tag, new TagToJsonTransformer(), $this->type);

            $manager = new Manager();
            $manager->setSerializer(new JsonApiSerializer($this->apiUrl));
            $content = $manager->createData($resource)->toJson();

            $response->setContent($content);
            $response->setStatusCode(Response::HTTP_OK);
        }
        else
        {
            $response->setStatusCode(Response::HTTP_NOT_FOUND);
        }

        return $response;
    }

    /**
     * @param int $id
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param ValidatorInterface $validator
     * @return Response
     *
     * @Route("/{id}", methods={"PATCH"}, name="tag_update")
     */
    public function update(int $id, Request $request, EntityManagerInterface $em, ValidatorInterface $validator) : Response
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/vnd.api+json');

        $tag = $em->getRepository(Tag::Class)->find($id);

        if ($tag)
        {
            $content = $request->getContent();
            $transformer = new JsonToTagTransformer();
            $tagNew = $transformer->transformSingle($content);

            if ($tagNew)
            {
                $errors = $validator->validate($tagNew);

                if (count($errors) == 0)
                {
                    $tag->setName($tagNew->getName());
                    $em->flush();
                    $resource = new Item($tag, new TagToJsonTransformer(), $this->type);

                    $manager = new Manager();
                    $manager->setSerializer(new JsonApiSerializer($this->apiUrl));
                    $content = $manager->createData($resource)->toJson();

                    $response->setContent($content);
                    $response->headers->set('Location', $this->baseUrl . '/' . $tag->getId());
                    $response->setStatusCode(Response::HTTP_OK);
                }
                else
                {
                    $transformer = new ErrorToJsonTransformer();
                    $errorMessage = $transformer->transform($errors);
                    $response->setContent($errorMessage);
                    $response->setStatusCode(Response::HTTP_BAD_REQUEST);
                }
            }
            else
            {
                $response->setStatusCode(Response::HTTP_FORBIDDEN);
            }
        }
        else
        {
            $response->setStatusCode(Response::HTTP_NOT_FOUND);
        }

        return $response;
    }

    /**
     * @param int $id
     * @param EntityManagerInterface $em
     * @return Response
     *
     * @Route("/{id}", methods={"DELETE"}, name="tag_delete")
     */
    public function delete(int $id, EntityManagerInterface $em) : Response
    {
        $response = new Response();

        $tag = $em->getRepository(Tag::Class)->find($id);

        if ($tag)
        {
            $em->remove($tag);
            $em->flush();

            $response->setStatusCode(Response::HTTP_ACCEPTED);
        }
        else
        {
            $response->setStatusCode(Response::HTTP_NOT_FOUND);
        }

        return $response;
    }
}