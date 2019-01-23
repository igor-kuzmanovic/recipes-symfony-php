<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/images")
 */
class ImageController extends AbstractController
{
    private $imageUrl = 'http://localhost:8000/images';

    /**
     * @param Request $request
     * @return Response
     *
     * @Route("", methods={"POST"}, name="upload_image")
     */
    public function upload(Request $request) : Response
    {
        $response = new Response();

        $file = $request->files->get("image");
        $mimeType = $file->getMimeType();

        if (preg_match('/image\/.+/', $mimeType) && $file->isValid())
        {
            $id = md5(uniqid());
            $fileName = $id.'.'.$file->guessExtension();
            $file->move("./images", $fileName);

            $response->headers->set('Location', $this->imageUrl.'/'.$fileName);
            $response->setStatusCode(Response::HTTP_CREATED);
        }
        else
        {
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
        }

        return $response;
    }
}