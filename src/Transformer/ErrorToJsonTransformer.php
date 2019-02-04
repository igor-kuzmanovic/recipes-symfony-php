<?php

namespace App\Transformer;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ErrorToJsonTransformer
{
    /**
     * @param ConstraintViolationListInterface $errors
     * @return string
     */
    public function transform(ConstraintViolationListInterface $errors)
    {
        $errorMessage = '';
        $errorMessage .= '{"errors":[';

        foreach ($errors as $error)
        {
            $errorMessage .= '{';
            $errorMessage .= '"source":'.'"'.$error->getPropertyPath().'",';
            $errorMessage .= '"title":"Not acceptable",';
            $errorMessage .= '"detail":'.'"'.$error->getMessage().'",';
            $errorMessage .= '"status":'.'"'.Response::HTTP_NOT_ACCEPTABLE.'",';
            $errorMessage .= '"code":'.'"'.$error->getCode().'"';
            $errorMessage .= '},';
        }
        
        $errorMessage = substr($errorMessage, 0, -1);
        $errorMessage .= ']}';

        return $errorMessage;
    }
}