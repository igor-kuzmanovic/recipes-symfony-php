<?php

namespace App\Controller;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api/categories")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/", methods={"POST"}, name="category_create")
     */
    public function create(Request $request, SerializerInterface $serializer, EntityManagerInterface $em) : Response
    {
        $response = null;

        $jsonCategory = $request->getContent();
        $category = $serializer->deserialize($jsonCategory, Category::class, 'json');

        $em->persist($category);
        $em->flush();

        $response = $this->json([
            'id' => $category->getId()
        ]);

        return $response;
    }

    /**
     * @Route("/{id}", methods={"GET"}, defaults={"id"=0}, name="category_read")
     */
    public function read(int $id, EntityManagerInterface $em) : Response
    {
        $response = null;

        if ($id > 0)
        {
            $category = $em->find(Category::class, $id);

            if ($category)
            {
                $response = $this->json($category);
            }
            else
            {
                $response = new Response("Not found.", Response::HTTP_NOT_FOUND);
            }
        }
        else
        {
            $categorys = $em->getRepository(Category::class)->findAll();

            $response = $this->json($categorys);
        }

        return $response;
    }

    /**
     * @Route("/{id}", methods={"PATCH"}, defaults={"id"=0}, name="category_update")
     */
    public function update(int $id, Request $request, SerializerInterface $serializer, EntityManagerInterface $em) : Response
    {
        $response = null;

        if ($id > 0)
        {
            $category = $em->find(Category::class, $id);

            if ($category)
            {
                $jsonUpdatedCategory = $request->getContent();
                $updatedCategory = $serializer->deserialize($jsonUpdatedCategory, Category::class,'json');
                $category->setName($updatedCategory->getName());

                $em->persist($category);
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
     * @Route("/{id}", methods={"DELETE"}, defaults={"id"=0}, name="category_delete")
     */
    public function delete(int $id, EntityManagerInterface $em) : Response
    {
        $response = null;

        if ($id > 0)
        {
            $category = $em->find(Category::class, $id);

            if ($category)
            {
                $em->remove($category);
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