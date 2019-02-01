<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class BaseController extends AbstractController
{
    protected $type = '';

    protected function getHost(Request $request)
    {
        return $request->getSchemeAndHttpHost();
    }
}