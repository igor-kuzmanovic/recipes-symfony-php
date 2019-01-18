<?php

namespace App\Controller;

use App\Entity\Recipe;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api/recipes")
 */
class RecipeController extends AbstractController
{
    /**
     * @Route("/", methods={"POST"}, name="recipe_create")
     */
    public function create(Request $request, SerializerInterface $serializer, EntityManagerInterface $em) : Response
    {
        $response = null;

        $jsonRecipe = $request->getContent();
        $recipe = $serializer->deserialize($jsonRecipe, Recipe::class, 'json');

        $em->persist($recipe);
        $em->flush();

        $response = $this->json([
            'id' => $recipe->getId()
        ]);

        return $response;
    }

    /**
     * @Route("/{id}", methods={"GET"}, defaults={"id"=0}, name="recipe_read")
     */
    public function read(int $id, EntityManagerInterface $em) : Response
    {
        $response = null;

        if ($id > 0)
        {
            $recipe = $em->find(Recipe::class, $id);

            if ($recipe)
            {
                $response = $this->json($recipe);
            }
            else
            {
                $response = new Response("Not found.", Response::HTTP_NOT_FOUND);
            }
        }
        else
        {
            $recipes = $em->getRepository(Recipe::class)->findAll();

            $response = $this->json($recipes);
        }

        return $response;
    }

    /**
     * @Route("/{id}", methods={"PATCH"}, defaults={"id"=0}, name="recipe_update")
     */
    public function update(int $id, Request $request, SerializerInterface $serializer, EntityManagerInterface $em) : Response
    {
        $response = null;

        if ($id > 0)
        {
            $recipe = $em->find(Recipe::class, $id);

            if ($recipe)
            {
                $jsonUpdatedRecipe = $request->getContent();
                $updatedRecipe = $serializer->deserialize($jsonUpdatedRecipe, Recipe::class,'json');
                $recipe->setName($updatedRecipe->getName());

                $em->persist($recipe);
                $em->flush();

                $response = $this->json([
                   'id' => $id
                ]);
            }
            else
            {
                $response = new Response("Not found.", Response::HTTP_NOT_FOUND);
            }
        }
        else
        {
            $response = new Response("Bad request.", Response::HTTP_BAD_REQUEST);
        }

        return $response;
    }

    /**
     * @Route("/{id}", methods={"DELETE"}, defaults={"id"=0}, name="recipe_delete")
     */
    public function delete(int $id, EntityManagerInterface $em) : Response
    {
        $response = null;

        if ($id > 0)
        {
            $recipe = $em->find(Recipe::class, $id);

            if ($recipe)
            {
                $em->remove($recipe);
                $em->flush();

                $response = $this->json([
                    'id' => $id
                ]);
            }
            else
            {
                $response = new Response("Not found.", Response::HTTP_NOT_FOUND);
            }
        }
        else
        {
            $response = new Response("Bad request.", Response::HTTP_BAD_REQUEST);
        }

        return $response;
    }
}