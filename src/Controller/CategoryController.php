<?php

namespace App\Controller;

use App\Entity\Category;
use App\Transformer\ErrorToJsonTransformer;
use App\Transformer\JsonToCategoryTransformer;
use App\Transformer\CategoryToJsonTransformer;
use Doctrine\ORM\EntityManagerInterface;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;
use League\Fractal\Serializer\JsonApiSerializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/api/categories")
 */
class CategoryController extends BaseController
{
    protected $type = 'categories';

    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param ValidatorInterface $validator
     * @return Response
     *
     * @Route("", methods={"POST"}, name="category_create")
     */
    public function create(Request $request, EntityManagerInterface $em, ValidatorInterface $validator) : Response
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/vnd.api+json');

        $content = $request->getContent();
        $transformer = new JsonToCategoryTransformer();
        $category = new Category();
        $transformer->transformSingle($category, $content);

        if ($category)
        {
            $errors = $validator->validate($category);

            if (count($errors) == 0) {
                $em->persist($category);
                $em->flush();
                $resource = new Item($category, new CategoryToJsonTransformer(), $this->type);

                $manager = new Manager();
                $manager->setSerializer(new JsonApiSerializer());
                $content = $manager->createData($resource)->toJson();

                $response->setContent($content);
                $response->headers->set('Location', '/' . $category->getId());
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
     * @Route("", methods={"GET"}, name="category_read_all")
     */
    public function readAll(Request $request, EntityManagerInterface $em) : Response
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/vnd.api+json');

        $category = $em->getRepository(category::Class)->findAll();
        $resource = new Collection($category, new CategoryToJsonTransformer(), $this->type);

        $manager = new Manager();
        $manager->setSerializer(new JsonApiSerializer());
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
     * @Route("/{id}", methods={"GET"}, name="category_read")
     */
    public function read(int $id, Request $request, EntityManagerInterface $em) : Response
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/vnd.api+json');

        $category = $em->getRepository(Category::Class)->find($id);

        if ($category)
        {
            $resource = new Item($category, new CategoryToJsonTransformer(), $this->type);

            $manager = new Manager();
            $manager->setSerializer(new JsonApiSerializer());
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
     * @Route("/{id}", methods={"PATCH"}, name="category_update")
     */
    public function update(int $id, Request $request, EntityManagerInterface $em, ValidatorInterface $validator) : Response
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/vnd.api+json');

        $category = $em->getRepository(Category::Class)->find($id);

        if ($category)
        {
            $content = $request->getContent();
            $transformer = new JsonToCategoryTransformer();
            $transformer->transformSingle($category, $content);

            $errors = $validator->validate($category);

            if (count($errors) == 0) {
                $em->flush();
                $resource = new Item($category, new CategoryToJsonTransformer(), $this->type);

                $manager = new Manager();
                $manager->setSerializer(new JsonApiSerializer());
                $content = $manager->createData($resource)->toJson();

                $response->setContent($content);
                $response->headers->set('Location', '/' . $category->getId());
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
            $response->setStatusCode(Response::HTTP_NOT_FOUND);
        }

        return $response;
    }

    /**
     * @param int $id
     * @param EntityManagerInterface $em
     * @return Response
     *
     * @Route("/{id}", methods={"DELETE"}, name="category_delete")
     */
    public function delete(int $id, EntityManagerInterface $em) : Response
    {
        $response = new Response();

        $category = $em->getRepository(Category::Class)->find($id);

        if ($category)
        {
            $em->remove($category);
            $em->flush();

            $response->setStatusCode(Response::HTTP_NO_CONTENT);
        }
        else
        {
            $response->setStatusCode(Response::HTTP_NOT_FOUND);
        }

        return $response;
    }
}