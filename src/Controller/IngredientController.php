<?php

namespace App\Controller;

use App\Entity\Ingredient;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api/ingredients")
 */
class IngredientController extends AbstractController
{
    /**
     * @Route("/", methods={"POST"}, name="ingredient_create")
     */
    public function create(Request $request, SerializerInterface $serializer, EntityManagerInterface $em) : Response
    {
        $response = null;

        $jsonIngredient = $request->getContent();
        $ingredient = $serializer->deserialize($jsonIngredient, Ingredient::class, 'json');

        $em->persist($ingredient);
        $em->flush();

        $response = $this->json([
            'id' => $ingredient->getId()
        ]);

        return $response;
    }

    /**
     * @Route("/{id}", methods={"GET"}, defaults={"id"=0}, name="ingredient_read")
     */
    public function read(int $id, EntityManagerInterface $em) : Response
    {
        $response = null;

        if ($id > 0)
        {
            $ingredient = $em->find(Ingredient::class, $id);

            if ($ingredient)
            {
                $response = $this->json($ingredient);
            }
            else
            {
                $response = new Response("Not found.", Response::HTTP_NOT_FOUND);
            }
        }
        else
        {
            $ingredients = $em->getRepository(Ingredient::class)->findAll();

            $response = $this->json($ingredients);
        }

        return $response;
    }

    /**
     * @Route("/{id}", methods={"PATCH"}, defaults={"id"=0}, name="ingredient_update")
     */
    public function update(int $id, Request $request, SerializerInterface $serializer, EntityManagerInterface $em) : Response
    {
        $response = null;

        if ($id > 0)
        {
            $ingredient = $em->find(Ingredient::class, $id);

            if ($ingredient)
            {
                $jsonUpdatedIngredient = $request->getContent();
                $updatedIngredient = $serializer->deserialize($jsonUpdatedIngredient, Ingredient::class,'json');
                $ingredient->setName($updatedIngredient->getName());

                $em->persist($ingredient);
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
     * @Route("/{id}", methods={"DELETE"}, defaults={"id"=0}, name="ingredient_delete")
     */
    public function delete(int $id, EntityManagerInterface $em) : Response
    {
        $response = null;

        if ($id > 0)
        {
            $ingredient = $em->find(Ingredient::class, $id);

            if ($ingredient)
            {
                $em->remove($ingredient);
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