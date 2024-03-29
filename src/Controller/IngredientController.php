<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Transformer\ErrorToJsonTransformer;
use App\Transformer\JsonToIngredientTransformer;
use App\Transformer\IngredientToJsonTransformer;
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
 * @Route("/api/ingredients")
 */
class IngredientController extends BaseController
{
    protected $type = 'ingredients';

    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param ValidatorInterface $validator
     * @return Response
     *
     * @Route("", methods={"POST"}, name="ingredient_create")
     */
    public function create(Request $request, EntityManagerInterface $em, ValidatorInterface $validator) : Response
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/vnd.api+json');

        $content = $request->getContent();
        $transformer = new JsonToIngredientTransformer();
        $ingredient = new Ingredient();
        $transformer->transformSingle($ingredient, $content);

        if ($ingredient)
        {
            $errors = $validator->validate($ingredient);

            if (count($errors) == 0)
            {
                $em->persist($ingredient);
                $em->flush();
                $resource = new Item($ingredient, new IngredientToJsonTransformer(), $this->type);

                $manager = new Manager();
                $manager->setSerializer(new JsonApiSerializer());
                $content = $manager->createData($resource)->toJson();

                $response->setContent($content);
                $response->headers->set('Location', '/'.$ingredient->getId());
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
     * @Route("", methods={"GET"}, name="ingredient_read_all")
     */
    public function readAll(Request $request, EntityManagerInterface $em) : Response
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/vnd.api+json');

        $ingredients = $em->getRepository(ingredient::Class)->findAll();
        $resource = new Collection($ingredients, new IngredientToJsonTransformer(), $this->type);

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
     * @Route("/{id}", methods={"GET"}, name="ingredient_read")
     */
    public function read(int $id, Request $request, EntityManagerInterface $em) : Response
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/vnd.api+json');

        $ingredient = $em->getRepository(Ingredient::Class)->find($id);

        if ($ingredient)
        {
            $resource = new Item($ingredient, new IngredientToJsonTransformer(), $this->type);

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
     * @Route("/{id}", methods={"PATCH"}, name="ingredient_update")
     */
    public function update(int $id, Request $request, EntityManagerInterface $em, ValidatorInterface $validator) : Response
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/vnd.api+json');

        $ingredient = $em->getRepository(Ingredient::Class)->find($id);

        if ($ingredient)
        {
            $content = $request->getContent();
            $transformer = new JsonToIngredientTransformer();
            $transformer->transformSingle($ingredient, $content);

            $errors = $validator->validate($ingredient);

            if (count($errors) == 0)
            {
                $em->flush();
                $resource = new Item($ingredient, new IngredientToJsonTransformer(), $this->type);

                $manager = new Manager();
                $manager->setSerializer(new JsonApiSerializer());
                $content = $manager->createData($resource)->toJson();

                $response->setContent($content);
                $response->headers->set('Location', '/'.$ingredient->getId());
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
     * @Route("/{id}", methods={"DELETE"}, name="ingredient_delete")
     */
    public function delete(int $id, EntityManagerInterface $em) : Response
    {
        $response = new Response();

        $ingredient = $em->getRepository(Ingredient::Class)->find($id);

        if ($ingredient)
        {
            $em->remove($ingredient);
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