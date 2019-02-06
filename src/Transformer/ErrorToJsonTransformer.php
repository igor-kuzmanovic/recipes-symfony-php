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
        $message = '';
        $message .= '{"errors":[';

        foreach ($errors as $error)
        {
            $message .= '{';
            $message .= '"source":'.'"'.$error->getPropertyPath().'",';
            $message .= '"title":"Not acceptable",';
            $message .= '"detail":'.'"'.$error->getMessage().'",';
            $message .= '"status":'.'"'.Response::HTTP_NOT_ACCEPTABLE.'",';
            $message .= '"code":'.'"'.$error->getCode().'"';
            $message .= '},';
        }

        $message = substr($message, 0, -1);
        $message .= ']}';

        return $message;
    }
}