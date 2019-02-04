<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/images")
 */
class ImageController extends BaseController
{
    private $imagesUrl = '/images';
    private $imagesDirectory = './images';

    /**
     * @param Request $request
     * @return string
     */
    private function getImagesUrl(Request $request)
    {
        return $this->getHost($request).$this->imagesUrl;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @Route("", methods={"POST"}, name="upload_image")
     */
    public function upload(Request $request) : Response
    {
        $response = new Response();

        if ($request->files->has('file')) {
            $file = $request->files->get('file');
            $mimeType = $file->getMimeType();

            if (preg_match('/image\/.+/', $mimeType) && $file->isValid()) {
                $id = md5(uniqid());
                $fileName = $id . '.' . $file->guessExtension();
                $file->move($this->imagesDirectory, $fileName);
                $fileUrl = $this->getImagesUrl($request) . '/' . $fileName;

                $response->headers->set('Location', $fileUrl);
                $response->headers->set('Content-Type', 'application/json');
                $response->setContent('{"url":"' . $fileUrl . '"}');
                $response->setStatusCode(Response::HTTP_CREATED);
            } else {
                $response->setStatusCode(Response::HTTP_UNSUPPORTED_MEDIA_TYPE);
            }
        }
        else
        {
            $response->setStatusCode(Response::HTTP_FORBIDDEN);
        }

        return $response;
    }
}