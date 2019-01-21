<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Transformer\JsonToRecipeTransformer;
use App\Transformer\RecipeToJsonTransformer;
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
 * @Route("/api/recipes")
 */
class RecipeController extends AbstractController
{
    private $type = 'recipes';
    private $apiUrl = 'http://localhost:8000/api';
    private $baseUrl = 'http://localhost:8000/api/recipes';

    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param ValidatorInterface $validator
     *
     * @return Response
     * @throws
     *
     * @Route("/", methods={"POST"}, name="recipe_create")
     */
    public function create(Request $request, EntityManagerInterface $em, ValidatorInterface $validator) : Response
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/vnd.api+json');

        $content = $request->getContent();
        $transformer = new JsonToRecipeTransformer();
        $recipe = $transformer->transformSingle($content);
        if ($recipe)
        {
            $errors = $validator->validate($recipe);
            if (count($errors) == 0)
            {
                $recipe->setDate(new \DateTime('NOW'));
                $em->persist($recipe);
                $em->flush();
                $resource = new Item($recipe, new RecipeToJsonTransformer(), $this->type);

                $manager = new Manager();
                $manager->setSerializer(new JsonApiSerializer($this->apiUrl));
                $content = $manager->createData($resource)->toJson();

                $response->setContent($content);
                $response->headers->set('Location', $this->baseUrl.'/'.$recipe->getId());
                $response->setStatusCode(Response::HTTP_CREATED);
            }
            else
            {
                $response->setContent('{"errors":"TODO: Validation errors"}');
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
     *
     * @return Response
     *
     * @Route("/", methods={"GET"}, name="recipe_read_all")
     */
    public function readAll(Request $request, EntityManagerInterface $em) : Response
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/vnd.api+json');

        $recipe = $em->getRepository(recipe::Class)->findAll();
        $resource = new Collection($recipe, new RecipeToJsonTransformer(), $this->type);

        $manager = new Manager();
        $manager->setSerializer(new JsonApiSerializer($this->apiUrl));
        $query = $request->query;
        if ($query->has('include'))
        {
            $includes = $query->get('include');
            $manager->parseIncludes($includes);
        }
        $content = $manager->createData($resource)->toJson();

        $response->setContent($content);
        $response->setStatusCode(Response::HTTP_OK);

        return $response;
    }

    /**
     * @param int $id
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return Response
     *
     * @Route("/{id}", methods={"GET"}, name="recipe_read")
     */
    public function read(int $id, Request $request, EntityManagerInterface $em) : Response
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/vnd.api+json');

        $recipe = $em->getRepository(Recipe::Class)->find($id);
        if ($recipe)
        {
            $resource = new Item($recipe, new RecipeToJsonTransformer(), $this->type);

            $manager = new Manager();
            $manager->setSerializer(new JsonApiSerializer($this->apiUrl));
            $query = $request->query;
            if ($query->has('include'))
            {
                $includes = $query->get('include');
                $manager->parseIncludes($includes);
            }
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
     *
     * @return Response
     *
     * @Route("/{id}", methods={"PATCH"}, name="recipe_update")
     */
    public function update(int $id, Request $request, EntityManagerInterface $em, ValidatorInterface $validator) : Response
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/vnd.api+json');

        $recipe = $em->getRepository(Recipe::Class)->find($id);
        if ($recipe)
        {
            $content = $request->getContent();
            $transformer = new JsonToRecipeTransformer();
            $recipeNew = $transformer->transformSingle($content);
            if ($recipeNew)
            {
                $errors = $validator->validate($recipeNew);
                if (count($errors) == 0)
                {
                    $recipe->setTitle($recipeNew->getTitle());
                    $recipe->setDescription($recipeNew->getDescription());
                    $recipe->setIngredients($recipeNew->getIngredients());
                    $recipe->setCategory($recipeNew->getCategory());
                    $recipe->setTags($recipeNew->getTags());
                    $em->flush();
                    $resource = new Item($recipe, new RecipeToJsonTransformer(), $this->type);

                    $manager = new Manager();
                    $manager->setSerializer(new JsonApiSerializer($this->apiUrl));
                    $content = $manager->createData($resource)->toJson();

                    $response->setContent($content);
                    $response->headers->set('Location', $this->baseUrl.'/'.$recipe->getId());
                    $response->setStatusCode(Response::HTTP_OK);
                }
                else
                {
                    $response->setContent('{"errors":"TODO: Validation errors"}');
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
     *
     * @return Response
     *
     * @Route("/{id}", methods={"DELETE"}, name="recipe_delete")
     */
    public function delete(int $id, EntityManagerInterface $em) : Response
    {
        $response = new Response();

        $recipe = $em->getRepository(Recipe::Class)->find($id);
        if ($recipe)
        {
            $em->remove($recipe);
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