<?php

namespace App\Controller;

use App\Entity\Tag;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api/tags")
 */
class TagController extends AbstractController
{
    /**
     * @Route("/", methods={"POST"}, name="tag_create")
     */
    public function create(Request $request, SerializerInterface $serializer, EntityManagerInterface $em) : Response
    {
        $response = null;

        $jsonTag = $request->getContent();
        $tag = $serializer->deserialize($jsonTag, tag::class, 'json');

        $em->persist($tag);
        $em->flush();

        $response = $this->json([
            'id' => $tag->getId()
        ]);

        return $response;
    }

    /**
     * @Route("/{id}", methods={"GET"}, defaults={"id"=0}, name="tag_read")
     */
    public function read(int $id, EntityManagerInterface $em) : Response
    {
        $response = null;

        if ($id > 0)
        {
            $tag = $em->find(tag::class, $id);

            if ($tag)
            {
                $response = $this->json($tag);
            }
            else
            {
                $response = new Response("Not found.", Response::HTTP_NOT_FOUND);
            }
        }
        else
        {
            $tags = $em->getRepository(tag::class)->findAll();

            $response = $this->json($tags);
        }

        return $response;
    }

    /**
     * @Route("/{id}", methods={"PATCH"}, defaults={"id"=0}, name="tag_update")
     */
    public function update(int $id, Request $request, SerializerInterface $serializer, EntityManagerInterface $em) : Response
    {
        $response = null;

        if ($id > 0)
        {
            $tag = $em->find(tag::class, $id);

            if ($tag)
            {
                $jsonUpdatedtag = $request->getContent();
                $updatedtag = $serializer->deserialize($jsonUpdatedtag, tag::class,'json');
                $tag->setName($updatedtag->getName());

                $em->persist($tag);
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
     * @Route("/{id}", methods={"DELETE"}, defaults={"id"=0}, name="tag_delete")
     */
    public function delete(int $id, EntityManagerInterface $em) : Response
    {
        $response = null;

        if ($id > 0)
        {
            $tag = $em->find(tag::class, $id);

            if ($tag)
            {
                $em->remove($tag);
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