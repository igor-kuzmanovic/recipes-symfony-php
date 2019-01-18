<?php

namespace App\Controller;

use App\Entity\Ingredient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/ingredients")
 */
abstract class IngredientController extends AbstractController
{
    /**
     * @Route("/create/", methods={"POST"}, name="ingredient_create")
     */
    public function create(Ingredient $ingredient) : Response
    {

    }

    /**
     * @Route("/get/{id}", methods={"GET"}, defaults={"id"=0}, name="ingredient_read")
     */
    public function read(int $id) : Response
    {

    }

    /**
     * @Route("/put/{id}", methods={"PUT"}, defaults={"id"=0}, name="ingredient_update")
     */
    public function update(int $id, Ingredient $ingredient) : Response
    {

    }

    /**
     * @Route("/delete/{id}", methods={"DELETE"}, defaults={"id"=0}, name="ingredient_delete")
     */
    public function delete(int $id) : Response
    {

    }
}