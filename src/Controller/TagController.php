<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Transformer\TagTransformer;
use Doctrine\ORM\EntityManagerInterface;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;
use League\Fractal\Serializer\JsonApiSerializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/tags")
 */
class TagController extends AbstractController
{
    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return Response
     *
     * @Route("/", methods={"POST"}, name="tag_create")
     */
    public function create(Request $request, EntityManagerInterface $em) : Response
    {
        $response = new Response();



        return $response;
    }

    /**
     * @param int $id
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return Response
     *
     * @Route("/{id}", methods={"GET"}, name="tag_read")
     */
    public function read(int $id, Request $request, EntityManagerInterface $em) : Response
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        $manager = new Manager();
        $manager->setSerializer(new JsonApiSerializer());

        $tag = $em->getRepository(tag::Class)->find($id);

        $resource = new Item($tag, new TagTransformer(), 'tags');
        $data = $manager->createData($resource)->toJson();

        $response->setContent($data);
        return $response;
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return Response
     *
     * @Route("/", methods={"GET"}, name="tag_read_all")
     */
    public function readAll(Request $request, EntityManagerInterface $em) : Response
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        $manager = new Manager();
        $manager->setSerializer(new JsonApiSerializer());

        $tags = $em->getRepository(tag::Class)->findAll();

        $resource = new Collection($tags, new TagTransformer(), 'tags');
        $data = $manager->createData($resource)->toJson();

        $response->setContent($data);
        return $response;
    }

    /**
     * @param int $id
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return Response
     *
     * @Route("/{id}", methods={"PATCH"}, defaults={"id"=0}, name="tag_update")
     */
    public function update(int $id, Request $request, EntityManagerInterface $em) : Response
    {
        $response = new Response();

        return $response;
    }

    /**
     * @param int $id
     * @param EntityManagerInterface $em
     *
     * @return Response
     *
     * @Route("/{id}", methods={"DELETE"}, defaults={"id"=0}, name="tag_delete")
     */
    public function delete(int $id, EntityManagerInterface $em) : Response
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        $tag = $em->getRepository(tag::Class)->find($id);
        $em->remove($tag);
        $em->flush();

        return $response;
    }
}