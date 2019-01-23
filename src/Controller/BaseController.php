<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class BaseController extends AbstractController
{
    protected $type = '';

    protected function getApiUrl(Request $request)
    {
        return $request->getSchemeAndHttpHost().'/api';
    }

    protected function getBaseUrl(Request $request)
    {
        return $this->getApiUrl($request).'/'.$this->type;
    }
}